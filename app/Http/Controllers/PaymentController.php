<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Services\SslCertificateService;

class PaymentController extends Controller
{
    protected $sslService;

    public function __construct(SslCertificateService $sslService)
    {
        $this->sslService = $sslService;
    }

    public function initiate(Request $request)
    {
        $request->validate([
            'plan' => 'required|string',
            'amount' => 'required|numeric|min:1',
            'title' => 'required|string',
            'domain' => 'required|string',
            'organization' => 'required|string',
            'email' => 'required|email',
            'private_key_password' => 'nullable|string'
        ]);

        try {
            // Get Flutterwave configuration
            $flutterwavePublicKey = config('services.flutterwave.public_key');
            $flutterwaveSecretKey = config('services.flutterwave.secret_key');
            $flutterwaveUrl = config('services.flutterwave.url');

            if (!$flutterwavePublicKey || !$flutterwaveSecretKey) {
                return response()->json([
                    'success' => false,
                    'message' => 'Payment gateway not configured'
                ], 500);
            }

            // Create payment data for Flutterwave
            $paymentData = [
                'tx_ref' => 'SSL_' . time() . '_' . $request->user()->id,
                'amount' => $request->amount,
                'currency' => 'USD',
                'redirect_url' => route('payment.callback'),
                'customer' => [
                    'email' => $request->email,
                    'name' => $request->user()->name,
                    'phone_number' => $request->user()->phone ?? ''
                ],
                'customizations' => [
                    'title' => 'SSL Certificate Purchase',
                    'description' => $request->title . ' for ' . $request->domain,
                    'logo' => asset('images/logo.png')
                ],
                'meta' => [
                    'user_id' => $request->user()->id,
                    'plan' => $request->plan,
                    'domain' => $request->domain,
                    'organization' => $request->organization,
                    'private_key_password' => $request->private_key_password
                ]
            ];

            // Store payment data in session for callback
            session([
                'payment_data' => $paymentData,
                'certificate_data' => [
                    'plan' => $request->plan,
                    'domain' => $request->domain,
                    'organization' => $request->organization,
                    'email' => $request->email,
                    'private_key_password' => $request->private_key_password
                ]
            ]);

            // Initialize Flutterwave payment
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $flutterwaveSecretKey,
                'Content-Type' => 'application/json'
            ])->post($flutterwaveUrl . '/payments', $paymentData);

            if ($response->successful()) {
                $paymentResponse = $response->json();
                
                if ($paymentResponse['status'] === 'success') {
                    return response()->json([
                        'success' => true,
                        'payment_url' => $paymentResponse['data']['link']
                    ]);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Payment initialization failed'
                    ], 400);
                }
            } else {
                Log::error('Flutterwave payment initiation failed', [
                    'response' => $response->body(),
                    'status' => $response->status()
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Payment gateway error'
                ], 500);
            }

        } catch (\Exception $e) {
            Log::error('Payment initiation error', [
                'error' => $e->getMessage(),
                'user_id' => $request->user()->id
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing payment'
            ], 500);
        }
    }

    public function callback(Request $request)
    {
        try {
            // Verify payment with Flutterwave
            $transactionId = $request->query('transaction_id');
            $flutterwaveSecretKey = config('services.flutterwave.secret_key');
            $flutterwaveUrl = config('services.flutterwave.url');

            if (!$transactionId) {
                return redirect()->route('dashboard')->with('error', 'Invalid payment response');
            }

            // Verify transaction with Flutterwave
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $flutterwaveSecretKey,
                'Content-Type' => 'application/json'
            ])->get($flutterwaveUrl . '/transactions/' . $transactionId . '/verify');

            if (!$response->successful()) {
                return redirect()->route('dashboard')->with('error', 'Payment verification failed');
            }

            $paymentData = $response->json();
            
            if ($paymentData['status'] !== 'success' || $paymentData['data']['status'] !== 'successful') {
                return redirect()->route('dashboard')->with('error', 'Payment was not successful');
            }

            // Get stored certificate data
            $certificateData = session('certificate_data');
            if (!$certificateData) {
                return redirect()->route('dashboard')->with('error', 'Certificate data not found');
            }

            // Get user ID from session or request
            $userId = auth()->id();
            if (!$userId) {
                return redirect()->route('login')->with('error', 'Please log in to complete your purchase');
            }

            // Generate SSL certificate
            $validityDays = $this->getValidityDays($certificateData['plan']);
            
            $result = $this->sslService->generateSelfSignedCertificate([
                'common_name' => $certificateData['domain'],
                'organization' => $certificateData['organization'],
                'email' => $certificateData['email'],
                'valid_days' => $validityDays,
                'private_key_password' => $certificateData['private_key_password'] ?? null,
            ], $userId);

            // Clear session data
            session()->forget(['payment_data', 'certificate_data']);

            return redirect()->route('ssl-certificates.index')
                ->with('success', 'Payment successful! Your SSL certificate has been generated.');

        } catch (\Exception $e) {
            Log::error('Payment callback error', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id()
            ]);

            return redirect()->route('dashboard')->with('error', 'An error occurred while processing your payment');
        }
    }

    public function webhook(Request $request)
    {
        try {
            // Verify webhook signature
            $signature = $request->header('verif-hash');
            $flutterwaveSecretHash = config('services.flutterwave.secret_hash');

            if ($signature !== $flutterwaveSecretHash) {
                Log::warning('Invalid webhook signature', [
                    'signature' => $signature,
                    'expected' => $flutterwaveSecretHash
                ]);
                return response()->json(['status' => 'error'], 400);
            }

            $payload = $request->all();
            
            // Log webhook for debugging
            Log::info('Flutterwave webhook received', $payload);

            // Process webhook based on event type
            if ($payload['event'] === 'charge.completed' && $payload['data']['status'] === 'successful') {
                // Payment was successful, you can add additional processing here
                Log::info('Payment completed successfully', [
                    'transaction_id' => $payload['data']['id'],
                    'amount' => $payload['data']['amount'],
                    'currency' => $payload['data']['currency']
                ]);
            }

            return response()->json(['status' => 'success']);

        } catch (\Exception $e) {
            Log::error('Webhook processing error', [
                'error' => $e->getMessage(),
                'payload' => $request->all()
            ]);

            return response()->json(['status' => 'error'], 500);
        }
    }

    private function getValidityDays(string $plan): int
    {
        return match ($plan) {
            '1_month' => 30,
            '6_months' => 180,
            '1_year' => 365,
            '2_years' => 730,
            '5_years' => 1825,
            default => 365
        };
    }
} 
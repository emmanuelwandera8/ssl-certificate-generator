<?php

namespace App\Http\Controllers;

use App\Services\SslCertificateService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class SslCertificateController extends Controller
{
    protected SslCertificateService $sslService;

    public function __construct(SslCertificateService $sslService)
    {
        $this->sslService = $sslService;
    }

    /**
     * Show the SSL certificate generator form
     */
    public function index(): View
    {
        $certificates = $this->sslService->listCertificates();
        
        return view('ssl-certificates.index', compact('certificates'));
    }

    /**
     * Generate a new SSL certificate
     */
    public function generate(Request $request): JsonResponse
    {
        $config = $request->validate([
            'country' => 'required|string|size:2',
            'state' => 'required|string|max:255',
            'locality' => 'required|string|max:255',
            'organization' => 'required|string|max:255',
            'organizational_unit' => 'required|string|max:255',
            'common_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'valid_days' => 'required|integer|min:1|max:3650',
            'key_size' => 'required|in:1024,2048,4096',
            'private_key_password' => 'nullable|string|max:255',
        ]);

        // Validate configuration
        $validation = $this->sslService->validateConfig($config);
        if (!$validation['valid']) {
            return response()->json([
                'success' => false,
                'errors' => $validation['errors'],
            ], 422);
        }

        try {
            $result = $this->sslService->generateSelfSignedCertificate($config);
            
            return response()->json([
                'success' => true,
                'message' => 'SSL certificate generated successfully',
                'data' => $result,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to generate SSL certificate',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Download a certificate file
     */
    public function download(Request $request): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        $request->validate([
            'file_path' => 'required|string',
            'file_type' => 'required|in:private_key,certificate,combined,pfx',
        ]);

        $filePath = $request->input('file_path');
        $fileType = $request->input('file_type');

        if (!Storage::exists($filePath)) {
            abort(404, 'File not found');
        }

        $fileName = basename($filePath);
        
        return Storage::download($filePath, $fileName);
    }

    /**
     * Get certificate information
     */
    public function info(Request $request): JsonResponse
    {
        $request->validate([
            'certificate_path' => 'required|string',
        ]);

        $certificatePath = $request->input('certificate_path');
        $info = $this->sslService->getCertificateInfo($certificatePath);

        if (!$info) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid certificate file',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $info,
        ]);
    }

    /**
     * List all certificates
     */
    public function list(): JsonResponse
    {
        $certificates = $this->sslService->listCertificates();

        return response()->json([
            'success' => true,
            'data' => $certificates,
        ]);
    }

    /**
     * Delete a certificate
     */
    public function delete(Request $request): JsonResponse
    {
        $request->validate([
            'directory' => 'required|string',
        ]);

        $directory = $request->input('directory');
        
        if ($this->sslService->deleteCertificate($directory)) {
            return response()->json([
                'success' => true,
                'message' => 'Certificate deleted successfully',
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Failed to delete certificate',
        ], 500);
    }

    /**
     * Get certificate content for display
     */
    public function content(Request $request): JsonResponse
    {
        $request->validate([
            'file_path' => 'required|string',
        ]);

        $filePath = $request->input('file_path');

        if (!Storage::exists($filePath)) {
            return response()->json([
                'success' => false,
                'message' => 'File not found',
            ], 404);
        }

        $content = Storage::get($filePath);

        return response()->json([
            'success' => true,
            'data' => [
                'content' => $content,
                'file_name' => basename($filePath),
                'file_size' => Storage::size($filePath),
            ],
        ]);
    }
} 
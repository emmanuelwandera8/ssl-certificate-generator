<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class PaymentTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_payment_initiation_requires_authentication()
    {
        $response = $this->postJson('/payment/initiate', [
            'plan' => '1_month',
            'amount' => 5,
            'title' => '1 Month SSL Certificate',
            'domain' => 'example.com',
            'organization' => 'Test Org',
            'email' => 'test@example.com'
        ]);

        $response->assertStatus(401);
    }

    public function test_payment_initiation_with_valid_data()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->postJson('/payment/initiate', [
                'plan' => '1_month',
                'amount' => 5,
                'title' => '1 Month SSL Certificate',
                'domain' => 'example.com',
                'organization' => 'Test Organization',
                'email' => 'admin@example.com',
                'private_key_password' => 'testpassword'
            ]);

        // Should fail because Flutterwave is not configured in tests
        $response->assertStatus(500);
        $response->assertJson([
            'success' => false,
            'message' => 'Payment gateway not configured'
        ]);
    }

    public function test_payment_initiation_validation()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->postJson('/payment/initiate', [
                'plan' => '',
                'amount' => -1,
                'title' => '',
                'domain' => '',
                'organization' => '',
                'email' => 'invalid-email'
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            'plan', 'amount', 'title', 'domain', 'organization', 'email'
        ]);
    }

    public function test_contact_form_submission()
    {
        $response = $this->post('/contact', [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@example.com',
            'phone' => '+1234567890',
            'subject' => 'General Inquiry',
            'message' => 'This is a test message'
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');
    }

    public function test_contact_form_validation()
    {
        $response = $this->post('/contact', [
            'first_name' => '',
            'last_name' => '',
            'email' => 'invalid-email',
            'subject' => '',
            'message' => ''
        ]);

        $response->assertSessionHasErrors([
            'first_name', 'last_name', 'email', 'subject', 'message'
        ]);
    }

    public function test_pricing_page_loads()
    {
        $response = $this->get('/pricing');

        $response->assertStatus(200);
        $response->assertSee('SSL Certificate Pricing');
        $response->assertSee('$5');
        $response->assertSee('$25');
        $response->assertSee('$45');
    }

    public function test_contact_page_loads()
    {
        $response = $this->get('/contact');

        $response->assertStatus(200);
        $response->assertSee('Contact Us');
        $response->assertSee('Send us a Message');
    }

    public function test_landing_page_loads()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('SSLGen');
        $response->assertSee('Professional SSL');
        $response->assertSee('Certificates');
    }
} 
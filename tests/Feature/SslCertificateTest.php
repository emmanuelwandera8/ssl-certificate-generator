<?php

namespace Tests\Feature;

use App\Services\SslCertificateService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SslCertificateTest extends TestCase
{
    protected SslCertificateService $sslService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->sslService = app(SslCertificateService::class);
        Storage::fake('local');
    }

    public function test_can_generate_ssl_certificate()
    {
        $config = [
            'common_name' => 'test.example.com',
            'organization' => 'Test Organization',
            'organizational_unit' => 'IT Department',
            'country' => 'US',
            'state' => 'Test State',
            'locality' => 'Test City',
            'email' => 'test@example.com',
            'valid_days' => 365,
            'key_size' => 2048,
        ];

        $result = $this->sslService->generateSelfSignedCertificate($config);

        $this->assertTrue($result['success']);
        $this->assertEquals($config, $result['config']);
        $this->assertArrayHasKey('files', $result);
        $this->assertArrayHasKey('expires_at', $result);

        // Check if files were created
        $this->assertTrue(Storage::exists($result['files']['private_key']['path']));
        $this->assertTrue(Storage::exists($result['files']['certificate']['path']));
        $this->assertTrue(Storage::exists($result['files']['combined']['path']));
        $this->assertTrue(Storage::exists($result['files']['pfx']['path']));
    }

    public function test_can_validate_certificate_config()
    {
        $validConfig = [
            'common_name' => 'test.example.com',
            'organization' => 'Test Organization',
            'country' => 'US',
            'state' => 'Test State',
            'locality' => 'Test City',
            'email' => 'test@example.com',
            'valid_days' => 365,
            'key_size' => 2048,
        ];

        $validation = $this->sslService->validateConfig($validConfig);
        $this->assertTrue($validation['valid']);
        $this->assertEmpty($validation['errors']);

        // Test invalid config
        $invalidConfig = [
            'common_name' => '',
            'country' => 'USA', // Should be 2 letters
            'email' => 'invalid-email',
            'valid_days' => 0,
            'key_size' => 1025, // Invalid key size
        ];

        $validation = $this->sslService->validateConfig($invalidConfig);
        $this->assertFalse($validation['valid']);
        $this->assertNotEmpty($validation['errors']);
    }

    public function test_can_get_certificate_info()
    {
        // Generate a certificate first
        $config = [
            'common_name' => 'test.example.com',
            'organization' => 'Test Organization',
            'organizational_unit' => 'IT Department',
            'country' => 'US',
            'state' => 'Test State',
            'locality' => 'Test City',
            'email' => 'test@example.com',
            'valid_days' => 365,
            'key_size' => 2048,
        ];

        $result = $this->sslService->generateSelfSignedCertificate($config);
        $certificatePath = $result['files']['certificate']['path'];

        // Get certificate info
        $info = $this->sslService->getCertificateInfo($certificatePath);

        $this->assertNotNull($info);
        $this->assertEquals('test.example.com', $info['subject']['CN']);
        $this->assertEquals('Test Organization', $info['subject']['O']);
        $this->assertEquals('US', $info['subject']['C']);
        $this->assertFalse($info['is_expired']);
        $this->assertGreaterThan(0, $info['days_remaining']);
    }

    public function test_can_list_certificates()
    {
        // Generate multiple certificates
        $configs = [
            [
                'common_name' => 'test1.example.com',
                'organization' => 'Test Organization 1',
                'country' => 'US',
                'state' => 'Test State',
                'locality' => 'Test City',
                'email' => 'test1@example.com',
                'valid_days' => 365,
                'key_size' => 2048,
            ],
            [
                'common_name' => 'test2.example.com',
                'organization' => 'Test Organization 2',
                'country' => 'US',
                'state' => 'Test State',
                'locality' => 'Test City',
                'email' => 'test2@example.com',
                'valid_days' => 365,
                'key_size' => 2048,
            ],
        ];

        foreach ($configs as $config) {
            $this->sslService->generateSelfSignedCertificate($config);
        }

        $certificates = $this->sslService->listCertificates();

        $this->assertCount(2, $certificates);
        $this->assertEquals('test2.example.com', $certificates[0]['info']['subject']['CN']);
        $this->assertEquals('test1.example.com', $certificates[1]['info']['subject']['CN']);
    }

    public function test_can_delete_certificate()
    {
        // Generate a certificate
        $config = [
            'common_name' => 'test.example.com',
            'organization' => 'Test Organization',
            'country' => 'US',
            'state' => 'Test State',
            'locality' => 'Test City',
            'email' => 'test@example.com',
            'valid_days' => 365,
            'key_size' => 2048,
        ];

        $result = $this->sslService->generateSelfSignedCertificate($config);
        $directory = $result['files']['base_path'];

        // Verify files exist
        $this->assertTrue(Storage::exists($result['files']['private_key']['path']));
        $this->assertTrue(Storage::exists($result['files']['certificate']['path']));

        // Delete certificate
        $deleted = $this->sslService->deleteCertificate($directory);

        $this->assertTrue($deleted);
        $this->assertFalse(Storage::exists($result['files']['private_key']['path']));
        $this->assertFalse(Storage::exists($result['files']['certificate']['path']));
    }

    public function test_web_interface_can_generate_certificate()
    {
        $response = $this->post('/ssl-certificates/generate', [
            'common_name' => 'test.example.com',
            'organization' => 'Test Organization',
            'organizational_unit' => 'IT Department',
            'country' => 'US',
            'state' => 'Test State',
            'locality' => 'Test City',
            'email' => 'test@example.com',
            'valid_days' => 365,
            'key_size' => 2048,
        ]);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
        $response->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'files' => [
                    'private_key',
                    'certificate',
                    'combined',
                    'pfx',
                ],
                'config',
                'expires_at',
            ],
        ]);
    }

    public function test_web_interface_validates_input()
    {
        $response = $this->post('/ssl-certificates/generate', [
            'common_name' => '',
            'country' => 'USA', // Invalid: should be 2 letters
            'email' => 'invalid-email',
        ]);

        $response->assertStatus(422);
        $response->assertJson(['success' => false]);
    }

    public function test_can_access_ssl_certificates_page()
    {
        $response = $this->get('/ssl-certificates');

        $response->assertStatus(200);
        $response->assertViewIs('ssl-certificates.index');
    }
} 
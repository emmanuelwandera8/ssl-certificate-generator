<?php

namespace App\Console\Commands;

use App\Services\SslCertificateService;
use Illuminate\Console\Command;

class GenerateSslCertificate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ssl:generate 
                            {--common-name= : Common name for the certificate}
                            {--organization= : Organization name}
                            {--country= : Country code (2 letters)}
                            {--state= : State or province}
                            {--locality= : City or locality}
                            {--email= : Email address}
                            {--valid-days=365 : Validity period in days}
                            {--key-size=2048 : Key size in bits}
                            {--interactive : Run in interactive mode}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a self-signed SSL certificate';

    protected SslCertificateService $sslService;

    public function __construct(SslCertificateService $sslService)
    {
        parent::__construct();
        $this->sslService = $sslService;
    }

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $config = $this->getConfiguration();

        $this->info('Generating SSL certificate...');
        $this->newLine();

        try {
            $result = $this->sslService->generateSelfSignedCertificate($config);

            $this->info('✅ Certificate generated successfully!');
            $this->newLine();

            $this->displayCertificateInfo($result);

            return self::SUCCESS;
        } catch (\Exception $e) {
            $this->error('❌ Failed to generate certificate: ' . $e->getMessage());
            return self::FAILURE;
        }
    }

    /**
     * Get certificate configuration from options or interactive prompts
     */
    private function getConfiguration(): array
    {
        if ($this->option('interactive')) {
            return $this->getInteractiveConfiguration();
        }

        return [
            'common_name' => $this->option('common-name') ?: 'localhost',
            'organization' => $this->option('organization') ?: 'My Organization',
            'organizational_unit' => 'IT Department',
            'country' => $this->option('country') ?: 'US',
            'state' => $this->option('state') ?: 'State',
            'locality' => $this->option('locality') ?: 'City',
            'email' => $this->option('email') ?: 'admin@example.com',
            'valid_days' => (int) $this->option('valid-days'),
            'key_size' => (int) $this->option('key-size'),
        ];
    }

    /**
     * Get configuration through interactive prompts
     */
    private function getInteractiveConfiguration(): array
    {
        $this->info('SSL Certificate Configuration');
        $this->info('============================');
        $this->newLine();

        return [
            'common_name' => $this->ask('Common Name (CN)', 'localhost'),
            'organization' => $this->ask('Organization (O)', 'My Organization'),
            'organizational_unit' => $this->ask('Organizational Unit (OU)', 'IT Department'),
            'country' => $this->ask('Country (C) - 2 letter code', 'US'),
            'state' => $this->ask('State/Province (ST)', 'State'),
            'locality' => $this->ask('City/Locality (L)', 'City'),
            'email' => $this->ask('Email Address', 'admin@example.com'),
            'valid_days' => (int) $this->ask('Validity Period (days)', '365'),
            'key_size' => (int) $this->choice('Key Size', ['1024', '2048', '4096'], '2048'),
        ];
    }

    /**
     * Display certificate information
     */
    private function displayCertificateInfo(array $result): void
    {
        $this->info('Certificate Details:');
        $this->newLine();

        $this->table(
            ['Field', 'Value'],
            [
                ['Common Name', $result['config']['common_name']],
                ['Organization', $result['config']['organization']],
                ['Country', $result['config']['country']],
                ['State', $result['config']['state']],
                ['City', $result['config']['locality']],
                ['Email', $result['config']['email']],
                ['Valid Days', $result['config']['valid_days']],
                ['Key Size', $result['config']['key_size'] . ' bits'],
                ['Expires At', $result['expires_at']],
            ]
        );

        $this->newLine();
        $this->info('Generated Files:');
        $this->newLine();

        $this->table(
            ['File Type', 'Path', 'Size'],
            [
                ['Private Key', $result['files']['private_key']['path'], $this->formatBytes($result['files']['private_key']['size'])],
                ['Certificate', $result['files']['certificate']['path'], $this->formatBytes($result['files']['certificate']['size'])],
                ['Combined PEM', $result['files']['combined']['path'], $this->formatBytes($result['files']['combined']['size'])],
                ['PFX/P12', $result['files']['pfx']['path'], $this->formatBytes($result['files']['pfx']['size'])],
            ]
        );

        $this->newLine();
        $this->warn('⚠️  Important: Keep your private key secure and never share it!');
        $this->info('📁 Files are stored in: storage/app/' . $result['files']['base_path']);
    }

    /**
     * Format bytes to human readable format
     */
    private function formatBytes(int $bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        $bytes /= pow(1024, $pow);

        return round($bytes, 2) . ' ' . $units[$pow];
    }
} 
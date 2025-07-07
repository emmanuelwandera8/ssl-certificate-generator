<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SslCertificateService
{
    /**
     * Generate a self-signed SSL certificate
     *
     * @param array $config Certificate configuration
     * @param int|null $userId User ID to associate with the certificate
     * @return array Generated certificate files info
     */
    public function generateSelfSignedCertificate(array $config = [], ?int $userId = null): array
    {
        // Default configuration
        $defaultConfig = [
            'country' => 'US',
            'state' => 'State',
            'locality' => 'City',
            'organization' => 'Organization',
            'organizational_unit' => 'IT Department',
            'common_name' => 'localhost',
            'email' => 'admin@example.com',
            'valid_days' => 365,
            'key_size' => 2048,
            'digest_alg' => 'sha256',
            'x509_extensions' => 'v3_ca',
            'private_key_password' => null,
        ];

        $config = array_merge($defaultConfig, $config);

        // Generate private key
        $privateKey = $this->generatePrivateKey($config['key_size']);

        // Generate certificate signing request
        $csr = $this->generateCSR($privateKey, $config);

        // Generate self-signed certificate
        $certificate = $this->generateCertificate($privateKey, $csr, $config);

        // Save files
        $files = $this->saveCertificateFiles($privateKey, $certificate, $config, $userId);

        return [
            'success' => true,
            'files' => $files,
            'config' => $config,
            'expires_at' => date('Y-m-d H:i:s', time() + ($config['valid_days'] * 24 * 60 * 60)),
        ];
    }

    /**
     * Generate a private key
     *
     * @param int $keySize Key size in bits
     * @return resource|false
     */
    private function generatePrivateKey(int $keySize = 2048)
    {
        $config = [
            'private_key_bits' => $keySize,
            'private_key_type' => OPENSSL_KEYTYPE_RSA,
        ];

        return openssl_pkey_new($config);
    }

    /**
     * Generate a Certificate Signing Request (CSR)
     *
     * @param resource $privateKey Private key resource
     * @param array $config Certificate configuration
     * @return resource|false
     */
    private function generateCSR($privateKey, array $config)
    {
        $dn = [
            'countryName' => $config['country'],
            'stateOrProvinceName' => $config['state'],
            'localityName' => $config['locality'],
            'organizationName' => $config['organization'],
            'organizationalUnitName' => $config['organizational_unit'],
            'commonName' => $config['common_name'],
            'emailAddress' => $config['email'],
        ];

        return openssl_csr_new($dn, $privateKey, [
            'digest_alg' => $config['digest_alg'],
            'x509_extensions' => $config['x509_extensions'],
        ]);
    }

    /**
     * Generate a self-signed certificate from CSR
     *
     * @param resource $privateKey Private key resource
     * @param resource $csr Certificate signing request
     * @param array $config Certificate configuration
     * @return string|false
     */
    private function generateCertificate($privateKey, $csr, array $config)
    {
        return openssl_csr_sign($csr, null, $privateKey, $config['valid_days'], [
            'digest_alg' => $config['digest_alg'],
            'x509_extensions' => $config['x509_extensions'],
        ]);
    }

    /**
     * Save certificate files to storage
     *
     * @param resource $privateKey Private key resource
     * @param string $certificate Certificate content
     * @param array $config Certificate configuration
     * @return array
     */
    private function saveCertificateFiles($privateKey, $certificate, array $config, ?int $userId = null): array
    {
        $timestamp = now()->format('Y-m-d_H-i-s');
        $commonName = Str::slug($config['common_name']);
        $userPrefix = $userId ? "user_{$userId}" : "anonymous";
        $basePath = "ssl_certificates/{$userPrefix}/{$commonName}_{$timestamp}";

        // Export private key with optional password protection
        $passphrase = $config['private_key_password'] ?? null;
        openssl_pkey_export($privateKey, $privateKeyPem, $passphrase);
        $privateKeyPath = "{$basePath}/private.key";
        Storage::put($privateKeyPath, $privateKeyPem);

        // Export certificate
        openssl_x509_export($certificate, $certificatePem);
        $certificatePath = "{$basePath}/certificate.crt";
        Storage::put($certificatePath, $certificatePem);

        // Create combined PEM file (certificate + private key)
        $combinedPem = $certificatePem . "\n" . $privateKeyPem;
        $combinedPath = "{$basePath}/combined.pem";
        Storage::put($combinedPath, $combinedPem);

        // Create PFX/P12 file
        $pfxPath = "{$basePath}/certificate.pfx";
        $pfxContent = '';
        // Use the correct function signature for PHP 8+
        openssl_pkcs12_export($certificate, $pfxContent, $privateKey, $passphrase ?: '', ['friendly_name' => $config['common_name']]);
        Storage::put($pfxPath, $pfxContent);

        return [
            'private_key' => [
                'path' => $privateKeyPath,
                'size' => Storage::size($privateKeyPath),
                'content' => $privateKeyPem,
            ],
            'certificate' => [
                'path' => $certificatePath,
                'size' => Storage::size($certificatePath),
                'content' => $certificatePem,
            ],
            'combined' => [
                'path' => $combinedPath,
                'size' => Storage::size($combinedPath),
            ],
            'pfx' => [
                'path' => $pfxPath,
                'size' => Storage::size($pfxPath),
            ],
            'base_path' => $basePath,
        ];
    }

    /**
     * Get certificate information
     *
     * @param string $certificatePath Path to certificate file
     * @return array|null
     */
    public function getCertificateInfo(string $certificatePath): ?array
    {
        if (!Storage::exists($certificatePath)) {
            return null;
        }

        $certificateContent = Storage::get($certificatePath);
        $certificateData = openssl_x509_read($certificateContent);

        if (!$certificateData) {
            return null;
        }

        $certificateInfo = openssl_x509_parse($certificateData);

        return [
            'subject' => $certificateInfo['subject'],
            'issuer' => $certificateInfo['issuer'],
            'valid_from' => date('Y-m-d H:i:s', $certificateInfo['validFrom_time_t']),
            'valid_to' => date('Y-m-d H:i:s', $certificateInfo['validTo_time_t']),
            'serial_number' => $certificateInfo['serialNumber'],
            'signature_type' => $certificateInfo['signatureTypeSN'],
            'version' => $certificateInfo['version'],
            'is_expired' => time() > $certificateInfo['validTo_time_t'],
            'days_remaining' => max(0, ceil(($certificateInfo['validTo_time_t'] - time()) / (24 * 60 * 60))),
        ];
    }

    /**
     * Validate certificate configuration
     *
     * @param array $config Certificate configuration
     * @return array Validation result
     */
    public function validateConfig(array $config): array
    {
        $errors = [];

        if (empty($config['common_name'])) {
            $errors[] = 'Common name is required';
        }

        if (empty($config['country']) || strlen($config['country']) !== 2) {
            $errors[] = 'Country must be a 2-letter ISO code';
        }

        if (empty($config['organization'])) {
            $errors[] = 'Organization is required';
        }

        if (!filter_var($config['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Valid email address is required';
        }

        if ($config['valid_days'] < 1 || $config['valid_days'] > 3650) {
            $errors[] = 'Valid days must be between 1 and 3650';
        }

        if (!in_array($config['key_size'], [1024, 2048, 4096])) {
            $errors[] = 'Key size must be 1024, 2048, or 4096 bits';
        }

        return [
            'valid' => empty($errors),
            'errors' => $errors,
        ];
    }

    /**
     * List all generated certificates for a specific user
     *
     * @param int|null $userId User ID to filter certificates
     * @return array
     */
    public function listCertificates(?int $userId = null): array
    {
        $certificates = [];
        
        if ($userId) {
            // Only show certificates for the specific user
            $userDirectory = "ssl_certificates/user_{$userId}";
            if (Storage::exists($userDirectory)) {
                $directories = Storage::directories($userDirectory);
            } else {
                $directories = [];
            }
        } else {
            // Show all certificates (admin view)
            $directories = Storage::directories('ssl_certificates');
        }

        foreach ($directories as $directory) {
            $certificatePath = $directory . '/certificate.crt';
            
            if (Storage::exists($certificatePath)) {
                $info = $this->getCertificateInfo($certificatePath);
                if ($info) {
                    $certificates[] = [
                        'directory' => $directory,
                        'certificate_path' => $certificatePath,
                        'info' => $info,
                        'created_at' => Storage::lastModified($certificatePath),
                    ];
                }
            }
        }

        // Sort by creation date (newest first)
        usort($certificates, function ($a, $b) {
            return $b['created_at'] <=> $a['created_at'];
        });

        return $certificates;
    }

    /**
     * Delete a certificate directory
     *
     * @param string $directory Certificate directory
     * @return bool
     */
    public function deleteCertificate(string $directory): bool
    {
        if (Storage::exists($directory)) {
            return Storage::deleteDirectory($directory);
        }

        return false;
    }
} 
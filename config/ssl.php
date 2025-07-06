<?php

return [
    /*
    |--------------------------------------------------------------------------
    | SSL Certificate Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains configuration options for SSL certificate generation.
    |
    */

    /*
    |--------------------------------------------------------------------------
    | Default Certificate Settings
    |--------------------------------------------------------------------------
    |
    | These are the default values used when generating SSL certificates.
    |
    */
    'defaults' => [
        'country' => env('SSL_DEFAULT_COUNTRY', 'US'),
        'state' => env('SSL_DEFAULT_STATE', 'State'),
        'locality' => env('SSL_DEFAULT_LOCALITY', 'City'),
        'organization' => env('SSL_DEFAULT_ORGANIZATION', 'My Organization'),
        'organizational_unit' => env('SSL_DEFAULT_ORGANIZATIONAL_UNIT', 'IT Department'),
        'email' => env('SSL_DEFAULT_EMAIL', 'admin@example.com'),
        'valid_days' => env('SSL_DEFAULT_VALID_DAYS', 365),
        'key_size' => env('SSL_DEFAULT_KEY_SIZE', 2048),
        'digest_alg' => env('SSL_DEFAULT_DIGEST_ALG', 'sha256'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Storage Configuration
    |--------------------------------------------------------------------------
    |
    | Configure where SSL certificates are stored.
    |
    */
    'storage' => [
        'disk' => env('SSL_STORAGE_DISK', 'local'),
        'path' => env('SSL_STORAGE_PATH', 'ssl_certificates'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Security Settings
    |--------------------------------------------------------------------------
    |
    | Security-related configuration for certificate generation.
    |
    */
    'security' => [
        'min_key_size' => env('SSL_MIN_KEY_SIZE', 1024),
        'max_key_size' => env('SSL_MAX_KEY_SIZE', 4096),
        'min_valid_days' => env('SSL_MIN_VALID_DAYS', 1),
        'max_valid_days' => env('SSL_MAX_VALID_DAYS', 3650),
        'allowed_countries' => explode(',', env('SSL_ALLOWED_COUNTRIES', 'US,CA,GB,DE,FR,AU')),
    ],

    /*
    |--------------------------------------------------------------------------
    | File Formats
    |--------------------------------------------------------------------------
    |
    | Configure which file formats to generate.
    |
    */
    'formats' => [
        'private_key' => true,
        'certificate' => true,
        'combined' => true,
        'pfx' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Validation Rules
    |--------------------------------------------------------------------------
    |
    | Custom validation rules for certificate parameters.
    |
    */
    'validation' => [
        'common_name' => [
            'required' => true,
            'max_length' => 255,
            'pattern' => '/^[a-zA-Z0-9.-]+$/',
        ],
        'organization' => [
            'required' => true,
            'max_length' => 255,
        ],
        'country' => [
            'required' => true,
            'length' => 2,
            'pattern' => '/^[A-Z]{2}$/',
        ],
        'email' => [
            'required' => true,
            'email' => true,
        ],
    ],
]; 
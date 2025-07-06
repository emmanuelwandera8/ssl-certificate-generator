<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

# SSL Certificate Generator

A Laravel application for generating self-signed SSL certificates for development and testing purposes.

## Features

- 🛡️ Generate self-signed SSL certificates with customizable parameters
- 🌐 Web-based interface with modern UI
- 💻 Command-line interface for automation
- 📁 Multiple certificate formats (PEM, PFX/P12, Combined)
- 🔍 Certificate validation and information display
- 📊 Certificate management and listing
- 🗑️ Certificate deletion functionality

## Requirements

- PHP 8.2 or higher
- Laravel 12.0 or higher
- OpenSSL extension enabled

## Installation

1. Clone the repository:
```bash
git clone <repository-url>
cd ssl-certificate-generator
```

2. Install dependencies:
```bash
composer install
```

3. Copy environment file:
```bash
cp .env.example .env
```

4. Generate application key:
```bash
php artisan key:generate
```

5. Run migrations (if using database features):
```bash
php artisan migrate
```

6. Start the development server:
```bash
php artisan serve
```

## Usage

### Web Interface

1. Navigate to `http://localhost:8000` in your browser
2. Fill out the certificate configuration form
3. Click "Generate Certificate"
4. Download the generated certificate files

### Command Line Interface

#### Interactive Mode
```bash
php artisan ssl:generate --interactive
```

#### With Options
```bash
php artisan ssl:generate \
    --common-name=example.com \
    --organization="My Company Inc." \
    --country=US \
    --state=California \
    --locality=San Francisco \
    --email=admin@example.com \
    --valid-days=365 \
    --key-size=2048
```

#### Quick Generation
```bash
php artisan ssl:generate --common-name=localhost
```

### API Endpoints

The application provides RESTful API endpoints for programmatic access:

- `GET /ssl-certificates` - List all certificates
- `POST /ssl-certificates/generate` - Generate new certificate
- `GET /ssl-certificates/download` - Download certificate file
- `GET /ssl-certificates/info` - Get certificate information
- `DELETE /ssl-certificates/delete` - Delete certificate
- `GET /ssl-certificates/content` - Get certificate content

## Certificate Configuration

### Required Fields

- **Common Name (CN)**: The domain name for the certificate (e.g., `localhost`, `example.com`)
- **Organization (O)**: Organization name
- **Country (C)**: 2-letter ISO country code (e.g., `US`, `GB`)
- **State/Province (ST)**: State or province name
- **City/Locality (L)**: City or locality name
- **Email**: Email address

### Optional Fields

- **Organizational Unit (OU)**: Department or unit within the organization
- **Validity Period**: Number of days the certificate is valid (1-3650)
- **Key Size**: RSA key size in bits (1024, 2048, or 4096)

## Generated Files

For each certificate, the following files are generated:

1. **Private Key** (`private.key`) - The private key file (keep secure!)
2. **Certificate** (`certificate.crt`) - The public certificate file
3. **Combined PEM** (`combined.pem`) - Certificate and private key in one file
4. **PFX/P12** (`certificate.pfx`) - PKCS#12 format for Windows/IIS

## File Storage

Certificates are stored in `storage/app/ssl_certificates/` with the following structure:

```
storage/app/ssl_certificates/
├── domain_name_timestamp/
│   ├── private.key
│   ├── certificate.crt
│   ├── combined.pem
│   └── certificate.pfx
```

## Security Considerations

⚠️ **Important Security Notes:**

1. **Private Key Security**: Never share or expose your private key files
2. **Self-Signed Certificates**: These certificates are not trusted by browsers by default
3. **Development Use**: Intended for development and testing environments only
4. **Production**: Use certificates from trusted Certificate Authorities for production

## Browser Trust

To trust a self-signed certificate in your browser:

### Chrome/Edge
1. Navigate to `chrome://settings/certificates`
2. Import the certificate file
3. Trust it for websites

### Firefox
1. Navigate to `about:preferences#privacy`
2. Click "View Certificates"
3. Import the certificate and trust it

### Safari
1. Double-click the certificate file
2. Add it to your login keychain
3. Trust it for websites

## Troubleshooting

### Common Issues

1. **OpenSSL Extension Missing**
   ```
   Error: openssl_pkey_new(): OpenSSL extension is not available
   ```
   Solution: Enable the OpenSSL extension in your PHP configuration

2. **Permission Denied**
   ```
   Error: Failed to write certificate files
   ```
   Solution: Ensure write permissions on the `storage/app/` directory

3. **Invalid Certificate Configuration**
   ```
   Error: Validation failed
   ```
   Solution: Check that all required fields are provided and valid

### Debug Mode

Enable debug mode in `.env`:
```
APP_DEBUG=true
```

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Add tests if applicable
5. Submit a pull request

## License

This project is open-sourced software licensed under the [MIT license](LICENSE).

## Support

For support and questions, please open an issue on the GitHub repository.

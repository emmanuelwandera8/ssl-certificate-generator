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

A Laravel-based SSL certificate generation service with Flutterwave payment integration. Users can sign up, purchase SSL certificates with different validity periods, and download them in multiple formats.

## Features

- **User Authentication**: Laravel Breeze authentication system
- **SSL Certificate Generation**: Self-signed certificates with configurable validity periods
- **Payment Integration**: Flutterwave payment gateway for secure transactions
- **Multiple Formats**: PEM, PFX/P12, and combined certificate formats
- **Password Protection**: Optional private key password protection
- **User Dashboard**: Manage and download certificates
- **Responsive Design**: Modern UI with Tailwind CSS and Alpine.js

## Pricing Plans

- **1 Month**: $5 - Perfect for testing and development
- **6 Months**: $25 - Most popular for small projects
- **1 Year**: $45 - Best value for production websites
- **2 Years**: $80 - Long-term security for established sites
- **5 Years**: $200 - Maximum security for enterprise
- **Custom**: Contact us for custom durations and bulk pricing

## Requirements

- PHP 8.1 or higher
- Laravel 10.x
- MySQL/PostgreSQL database
- Composer
- Node.js and NPM (for frontend assets)

## Installation

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd ssl-certificate-generator
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install Node.js dependencies**
   ```bash
   npm install
   ```

4. **Copy environment file**
   ```bash
   cp .env.example .env
   ```

5. **Generate application key**
   ```bash
   php artisan key:generate
   ```

6. **Configure database**
   Edit `.env` file with your database credentials:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=ssl_certificate_generator
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

7. **Run database migrations**
   ```bash
   php artisan migrate
   ```

8. **Configure Flutterwave**
   Add your Flutterwave credentials to `.env`:
   ```env
   FLUTTERWAVE_PUBLIC_KEY=your_public_key
   FLUTTERWAVE_SECRET_KEY=your_secret_key
   FLUTTERWAVE_SECRET_HASH=your_secret_hash
   FLUTTERWAVE_URL=https://api.flutterwave.com/v3
   FLUTTERWAVE_ENVIRONMENT=test
   ```

9. **Build frontend assets**
   ```bash
   npm run build
   ```

10. **Set up storage**
    ```bash
    php artisan storage:link
    ```

## Flutterwave Setup

1. **Create Flutterwave Account**
   - Sign up at [Flutterwave](https://flutterwave.com)
   - Complete account verification

2. **Get API Keys**
   - Go to your Flutterwave dashboard
   - Navigate to Settings > API Keys
   - Copy your public key, secret key, and secret hash

3. **Configure Webhook**
   - Set webhook URL: `https://yourdomain.com/payment/webhook`
   - Use the secret hash for webhook verification

4. **Test Mode**
   - Use test credentials for development
   - Switch to live credentials for production

## Usage

### For Users

1. **Sign Up/Login**
   - Visit the homepage and click "Sign Up"
   - Complete registration process

2. **Purchase Certificate**
   - Go to Pricing page
   - Select desired validity period
   - Fill in certificate details
   - Complete payment via Flutterwave

3. **Download Certificate**
   - After successful payment, certificate is generated automatically
   - Download in PEM, PFX, or combined format
   - Private key is password-protected if specified

### For Administrators

1. **Monitor Payments**
   - Check Laravel logs for payment webhooks
   - Monitor Flutterwave dashboard for transactions

2. **Manage Certificates**
   - Certificates are stored in `storage/app/ssl_certificates/`
   - Organized by user ID and timestamp

3. **Support**
   - Contact form submissions are logged
   - Check `storage/logs/laravel.log` for details

## File Structure

```
ssl-certificate-generator/
├── app/
│   ├── Http/Controllers/
│   │   ├── SslCertificateController.php
│   │   ├── PaymentController.php
│   │   └── ContactController.php
│   ├── Services/
│   │   └── SslCertificateService.php
│   └── Models/
│       └── User.php
├── resources/views/
│   ├── welcome.blade.php
│   ├── pricing.blade.php
│   ├── contact.blade.php
│   └── ssl-certificates/
│       └── index.blade.php
├── routes/
│   └── web.php
└── config/
    └── services.php
```

## Security Features

- **CSRF Protection**: All forms protected against CSRF attacks
- **Authentication Required**: SSL certificate generation requires login
- **User Isolation**: Users can only access their own certificates
- **Password Protection**: Optional private key encryption
- **Secure Storage**: Certificates stored in private storage directory
- **Payment Verification**: Server-side payment verification with Flutterwave

## API Endpoints

### Public Routes
- `GET /` - Landing page
- `GET /pricing` - Pricing page
- `GET /contact` - Contact page
- `POST /contact` - Submit contact form

### Authenticated Routes
- `GET /dashboard` - User dashboard
- `GET /ssl-certificates` - Certificate management
- `POST /ssl-certificates/generate` - Generate certificate
- `POST /payment/initiate` - Initiate payment
- `GET /payment/callback` - Payment callback

### Webhook Routes
- `POST /payment/webhook` - Flutterwave webhook

## Testing

Run the test suite:
```bash
php artisan test
```

## Deployment

1. **Production Environment**
   - Set `APP_ENV=production`
   - Set `APP_DEBUG=false`
   - Use live Flutterwave credentials

2. **SSL Certificate**
   - Install SSL certificate on your domain
   - Update `APP_URL` to use HTTPS

3. **Database**
   - Use production database
   - Set up database backups

4. **Storage**
   - Configure cloud storage if needed
   - Set up proper file permissions

## Troubleshooting

### Common Issues

1. **Payment Not Processing**
   - Check Flutterwave credentials
   - Verify webhook configuration
   - Check Laravel logs for errors

2. **Certificate Generation Fails**
   - Ensure OpenSSL is installed
   - Check storage permissions
   - Verify domain name format

3. **File Download Issues**
   - Check storage link is created
   - Verify file permissions
   - Check file paths in database

### Logs

Check Laravel logs for debugging:
```bash
tail -f storage/logs/laravel.log
```

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Add tests
5. Submit a pull request

## License

This project is licensed under the MIT License.

## Support

For support, please contact us through the contact form on the website or email support@sslgen.com.

## Changelog

### v1.0.0
- Initial release
- User authentication
- SSL certificate generation
- Flutterwave payment integration
- Multiple certificate formats
- Responsive design

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Sign In - {{ config('app.name', 'SSL Certificate Generator') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    
    <style>
        .login-container {
            min-height: calc(100vh - 140px); /* Account for navbar and footer */
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 20px;
            margin-top: 80px; /* Space for fixed navbar */
        }
        
        .login-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            width: 100%;
            max-width: 900px;
            display: flex;
            min-height: 600px;
        }
        
        .login-form-section {
            flex: 1;
            padding: 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .login-hero-section {
            flex: 1;
            background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%);
            color: white;
            padding: 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }
        
        .login-hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="white" opacity="0.1"/><circle cx="10" cy="60" r="0.5" fill="white" opacity="0.1"/><circle cx="90" cy="40" r="0.5" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
        }
        
        .login-hero-content {
            position: relative;
            z-index: 1;
        }
        
        .login-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: #1f2937;
        }
        
        .login-subtitle {
            color: #6b7280;
            margin-bottom: 2rem;
            font-size: 1.1rem;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #374151;
            font-size: 0.9rem;
        }
        
        .form-input {
            width: 100%;
            padding: 1rem 1.25rem;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #f9fafb;
        }
        
        .form-input:focus {
            outline: none;
            border-color: #3b82f6;
            background: white;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        }
        
        .form-input:hover {
            border-color: #d1d5db;
            background: white;
        }
        
        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }
        
        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .checkbox-group input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: #3b82f6;
        }
        
        .checkbox-group label {
            font-size: 0.9rem;
            color: #6b7280;
            cursor: pointer;
        }
        
        .forgot-link {
            font-size: 0.9rem;
            color: #3b82f6;
            text-decoration: none;
            font-weight: 500;
        }
        
        .forgot-link:hover {
            text-decoration: underline;
        }
        
        .login-btn {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }
        
        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(59, 130, 246, 0.3);
        }
        
        .login-btn:active {
            transform: translateY(0);
        }
        
        .signup-link {
            text-align: center;
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid #e5e7eb;
        }
        
        .signup-link p {
            color: #6b7280;
            margin-bottom: 0.5rem;
        }
        
        .signup-link a {
            color: #3b82f6;
            text-decoration: none;
            font-weight: 600;
        }
        
        .signup-link a:hover {
            text-decoration: underline;
        }
        
        .hero-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }
        
        .hero-subtitle {
            font-size: 1.1rem;
            opacity: 0.9;
            margin-bottom: 2rem;
            line-height: 1.6;
        }
        
        .feature-list {
            list-style: none;
            padding: 0;
        }
        
        .feature-list li {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
            font-size: 1rem;
        }
        
        .feature-list li::before {
            content: '✓';
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 24px;
            height: 24px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            margin-right: 1rem;
            font-weight: bold;
            font-size: 0.8rem;
        }
        
        .error-message {
            background: #fef2f2;
            color: #dc2626;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 2rem;
            border: 1px solid #fecaca;
        }
        
        .error-message ul {
            margin: 0;
            padding-left: 1.5rem;
        }
        
        @media (max-width: 768px) {
            .login-container {
                margin-top: 70px;
                min-height: calc(100vh - 120px);
            }
            
            .login-card {
                flex-direction: column;
                max-width: 500px;
            }
            
            .login-hero-section {
                order: -1;
                padding: 2rem;
            }
            
            .login-form-section {
                padding: 2rem;
            }
            
            .login-title {
                font-size: 2rem;
            }
            
            .hero-title {
                font-size: 2rem;
            }
        }
        
        @media (max-width: 480px) {
            .login-container {
                padding: 10px;
                margin-top: 60px;
            }
            
            .login-form-section,
            .login-hero-section {
                padding: 1.5rem;
            }
            
            .login-title {
                font-size: 1.75rem;
            }
            
            .hero-title {
                font-size: 1.75rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="navbar-container">
            <a href="{{ route('welcome') }}" class="logo">
                <div class="logo-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <span class="gradient-text">SSLGen</span>
            </a>
            <div class="nav-links">
                <a href="{{ route('welcome') }}" class="nav-link">Home</a>
                <a href="{{ route('pricing') }}" class="nav-link">Pricing</a>
                <a href="{{ route('contact') }}" class="nav-link">Contact</a>
                @auth
                    <a href="{{ route('dashboard') }}" class="btn btn-primary">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="nav-link" style="color: #3b82f6; background: rgba(59, 130, 246, 0.1);">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-primary">Get Started</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Login Container -->
    <div class="login-container">
        <div class="login-card">
            <!-- Login Form Section -->
            <div class="login-form-section">
                <div>
                    <h1 class="login-title">Welcome Back</h1>
                    <p class="login-subtitle">Sign in to access your SSL certificates and manage your account</p>

                    @if($errors->any())
                        <div class="error-message">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-input" required autofocus autocomplete="email" placeholder="Enter your email">
        </div>

                        <div class="form-group">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" id="password" name="password" class="form-input" required autocomplete="current-password" placeholder="Enter your password">
        </div>

                        <div class="form-options">
                            <label class="checkbox-group">
                                <input type="checkbox" name="remember">
                                <span>Remember me</span>
                            </label>
            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="forgot-link">Forgot password?</a>
            @endif
                        </div>

                        <button type="submit" class="login-btn">
                            <i class="fas fa-sign-in-alt"></i>
                            Sign In
                        </button>
                    </form>

                    <div class="signup-link">
                        <p>Don't have an account?</p>
                        <a href="{{ route('register') }}">Create a new account</a>
                    </div>
                </div>
            </div>

            <!-- Hero Section -->
            <div class="login-hero-section">
                <div class="login-hero-content">
                    <h2 class="hero-title">Secure Your Applications</h2>
                    <p class="hero-subtitle">Generate and manage SSL certificates with our professional platform. Keep your websites and applications secure with enterprise-grade certificates.</p>
                    
                    <ul class="feature-list">
                        <li>Generate certificates instantly</li>
                        <li>Access certificate history</li>
                        <li>Download in multiple formats</li>
                        <li>Priority customer support</li>
                        <li>Secure certificate storage</li>
                        <li>Expiry notifications</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div>
                    <div class="footer-brand">
                        <div class="footer-logo">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <span style="font-size: 1.5rem; font-weight: bold;">SSLGen</span>
                    </div>
                    <p class="footer-description">
                        Professional SSL certificate generation service. Secure your websites and applications with our reliable certificate generation platform.
                    </p>
                </div>
                <div class="footer-section">
                    <h3>Services</h3>
                    <ul class="footer-links">
                        <li><a href="{{ route('pricing') }}">Pricing</a></li>
                        <li><a href="{{ route('contact') }}">Support</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h3>Company</h3>
                    <ul class="footer-links">
                        <li><a href="{{ route('contact') }}">Contact</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Terms of Service</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} SSLGen. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>

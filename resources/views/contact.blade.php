<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Contact Us - {{ config('app.name', 'SSL Certificate Generator') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
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
                <a href="{{ route('contact') }}" class="nav-link" style="color: #3b82f6; background: rgba(59, 130, 246, 0.1);">Contact</a>
                @auth
                    <a href="{{ route('dashboard') }}" class="btn btn-primary">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="nav-link">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-primary">Get Started</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Contact Header -->
    <section class="hero" style="min-height: 60vh;">
        <div class="hero-content slide-in">
            <h1 class="hero-title" style="font-size: 3rem;">Get in Touch</h1>
            <p class="hero-subtitle" style="font-size: 1.25rem;">
                Have questions? We're here to help you secure your digital world.
            </p>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="section">
        <div class="container">
            <div class="grid grid-2" style="max-width: 1000px; margin: 0 auto;">
                <!-- Contact Form -->
                <div class="card">
                    <h2 style="font-size: 2rem; font-weight: bold; margin-bottom: 2rem; color: #111827;">Send us a Message</h2>
                    
                    @if(session('success'))
                        <div style="background: #d1fae5; color: #065f46; padding: 1rem; border-radius: 8px; margin-bottom: 2rem; border: 1px solid #a7f3d0;">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div style="background: #fee2e2; color: #991b1b; padding: 1rem; border-radius: 8px; margin-bottom: 2rem; border: 1px solid #fca5a5;">
                            <ul style="margin: 0; padding-left: 1.5rem;">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('contact.submit') }}">
                        @csrf
                        <div class="form-group">
                            <label for="name" class="form-label">Full Name *</label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-input" required>
                        </div>

                        <div class="form-group">
                            <label for="email" class="form-label">Email Address *</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-input" required>
                        </div>

                        <div class="form-group">
                            <label for="subject" class="form-label">Subject *</label>
                            <select id="subject" name="subject" class="form-input" required>
                                <option value="">Select a subject</option>
                                <option value="General Inquiry" {{ old('subject') == 'General Inquiry' ? 'selected' : '' }}>General Inquiry</option>
                                <option value="Technical Support" {{ old('subject') == 'Technical Support' ? 'selected' : '' }}>Technical Support</option>
                                <option value="Billing Question" {{ old('subject') == 'Billing Question' ? 'selected' : '' }}>Billing Question</option>
                                <option value="Custom Certificate" {{ old('subject') == 'Custom Certificate' ? 'selected' : '' }}>Custom Certificate Request</option>
                                <option value="Partnership" {{ old('subject') == 'Partnership' ? 'selected' : '' }}>Partnership Inquiry</option>
                                <option value="Other" {{ old('subject') == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="message" class="form-label">Message *</label>
                            <textarea id="message" name="message" rows="6" class="form-input form-textarea" required>{{ old('message') }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary btn-large" style="width: 100%;">
                            <i class="fas fa-paper-plane" style="margin-right: 12px;"></i>
                            Send Message
                        </button>
                    </form>
                </div>

                <!-- Contact Information -->
                <div>
                    <div class="card">
                        <h2 style="font-size: 2rem; font-weight: bold; margin-bottom: 2rem; color: #111827;">Contact Information</h2>
                        
                        <div style="margin-bottom: 2rem;">
                            <div style="display: flex; align-items: center; margin-bottom: 1rem;">
                                <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-right: 1rem;">
                                    <i class="fas fa-envelope" style="color: white;"></i>
                                </div>
                                <div>
                                    <h3 style="font-weight: 600; margin-bottom: 0.25rem;">Email</h3>
                                    <p style="color: #6b7280;">support@sslgen.com</p>
                                </div>
                            </div>

                            <div style="display: flex; align-items: center; margin-bottom: 1rem;">
                                <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-right: 1rem;">
                                    <i class="fas fa-clock" style="color: white;"></i>
                                </div>
                                <div>
                                    <h3 style="font-weight: 600; margin-bottom: 0.25rem;">Response Time</h3>
                                    <p style="color: #6b7280;">Within 24 hours</p>
                                </div>
                            </div>

                            <div style="display: flex; align-items: center; margin-bottom: 1rem;">
                                <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-right: 1rem;">
                                    <i class="fas fa-headset" style="color: white;"></i>
                                </div>
                                <div>
                                    <h3 style="font-weight: 600; margin-bottom: 0.25rem;">Support Hours</h3>
                                    <p style="color: #6b7280;">Monday - Friday: 9AM - 6PM GMT</p>
                                </div>
                            </div>
                        </div>

                        <div style="background: #f8fafc; padding: 1.5rem; border-radius: 12px; border-left: 4px solid #3b82f6;">
                            <h3 style="font-weight: 600; margin-bottom: 1rem; color: #111827;">Need Immediate Help?</h3>
                            <p style="color: #6b7280; margin-bottom: 1rem;">For urgent technical issues, please include your certificate details and error messages in your inquiry.</p>
                            <a href="{{ route('pricing') }}" class="btn btn-primary">View Pricing</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="section" style="background-color: #f8fafc;">
        <div class="container">
            <h2 class="section-title">Frequently Asked Questions</h2>
            <p class="section-subtitle">Find quick answers to common questions about our SSL certificate service.</p>

            <div class="grid grid-2" style="max-width: 1000px; margin: 0 auto;">
                <div class="card">
                    <h3 style="font-weight: 600; margin-bottom: 1rem; color: #111827;">How long does it take to generate a certificate?</h3>
                    <p style="color: #6b7280;">Certificates are generated instantly after payment confirmation. You'll receive download links immediately.</p>
                </div>

                <div class="card">
                    <h3 style="font-weight: 600; margin-bottom: 1rem; color: #111827;">What formats are supported?</h3>
                    <p style="color: #6b7280;">We provide certificates in PEM, PFX, and combined formats compatible with all major web servers and platforms.</p>
                </div>

                <div class="card">
                    <h3 style="font-weight: 600; margin-bottom: 1rem; color: #111827;">Can I use these certificates for production?</h3>
                    <p style="color: #6b7280;">Yes, our certificates are suitable for production use and provide the same level of encryption as commercial certificates.</p>
                </div>

                <div class="card">
                    <h3 style="font-weight: 600; margin-bottom: 1rem; color: #111827;">Do you offer refunds?</h3>
                    <p style="color: #6b7280;">We offer a 30-day money-back guarantee if you're not satisfied with our service.</p>
                </div>
            </div>
        </div>
    </section>

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
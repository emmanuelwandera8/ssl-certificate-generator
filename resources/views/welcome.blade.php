<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SSL Certificate Generator') }}</title>

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
                <a href="{{ route('contact') }}" class="nav-link">Contact</a>
                    @auth
                    <a href="{{ route('dashboard') }}" class="btn btn-primary">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="nav-link">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-primary">Get Started</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <!-- Animated Background Elements -->
        <div class="floating" style="position: absolute; top: 20%; left: 10%; width: 300px; height: 300px; background: rgba(255, 255, 255, 0.1); border-radius: 50%; filter: blur(60px);"></div>
        <div class="floating" style="position: absolute; bottom: 20%; right: 10%; width: 400px; height: 400px; background: rgba(118, 75, 162, 0.1); border-radius: 50%; filter: blur(60px); animation-delay: 1s;"></div>
        <div class="floating" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 350px; height: 350px; background: rgba(59, 130, 246, 0.1); border-radius: 50%; filter: blur(60px); animation-delay: 2s;"></div>

        <div class="hero-content slide-in">
            <h1 class="hero-title">
                <span style="display: block;">Secure Your</span>
                <span style="display: block; background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">Digital World</span>
            </h1>
            <p class="hero-subtitle">
                Generate professional SSL certificates instantly. Protect your websites and applications with enterprise-grade security at affordable prices.
            </p>
            <div class="hero-buttons">
                <a href="{{ route('pricing') }}" class="btn btn-secondary btn-large">
                    <span>Explore Pricing</span>
                    <i class="fas fa-arrow-right" style="margin-left: 12px;"></i>
                </a>
                <a href="{{ route('register') }}" class="btn glass btn-large" style="background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2);">
                    <i class="fas fa-rocket" style="margin-right: 12px;"></i>
                    <span>Start Free Trial</span>
                </a>
            </div>
        </div>

        <!-- Scroll Indicator -->
        <div class="scroll-indicator"></div>
    </section>

    <!-- Features Section -->
    <section class="section">
        <div class="container">
            <h2 class="section-title">Why Choose SSLGen?</h2>
            <p class="section-subtitle">
                Experience the future of SSL certificate generation with cutting-edge technology and unmatched reliability.
            </p>

            <div class="grid grid-4">
                <div class="card card-feature">
                    <div class="card-icon gradient-blue">
                        <i class="fas fa-bolt"></i>
                    </div>
                    <h3 class="card-title">Lightning Fast</h3>
                    <p class="card-text">Generate certificates in seconds, not minutes. Instant delivery after payment confirmation.</p>
                </div>

                <div class="card card-feature">
                    <div class="card-icon gradient-green">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3 class="card-title">Military Grade</h3>
                    <p class="card-text">256-bit encryption with industry-standard security protocols and best practices.</p>
                </div>

                <div class="card card-feature">
                    <div class="card-icon gradient-purple">
                        <i class="fas fa-clock"></i>
                    </div>
                    <h3 class="card-title">Flexible Duration</h3>
                    <p class="card-text">Choose from 1 month to 10 years. Pay only for what you need with transparent pricing.</p>
                </div>

                <div class="card card-feature">
                    <div class="card-icon gradient-orange">
                        <i class="fas fa-download"></i>
                    </div>
                    <h3 class="card-title">Multiple Formats</h3>
                    <p class="card-text">Download in PEM, PFX, and combined formats. Compatible with all major platforms.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats">
        <div class="container">
            <div class="stats-grid">
                <div>
                    <div class="stat-number">10K+</div>
                    <div class="stat-label">Certificates Generated</div>
                </div>
                <div>
                    <div class="stat-number">99.9%</div>
                    <div class="stat-label">Uptime Guarantee</div>
                </div>
                <div>
                    <div class="stat-number">24/7</div>
                    <div class="stat-label">Support Available</div>
                </div>
                <div>
                    <div class="stat-number">5★</div>
                    <div class="stat-label">Customer Rating</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Preview -->
    <section class="section" style="background-color: #f8fafc;">
        <div class="container">
            <h2 class="section-title">Simple, Transparent Pricing</h2>
            <p class="section-subtitle">No hidden fees, no surprises. Choose the plan that fits your needs.</p>
            
            <div class="grid grid-3" style="max-width: 1000px; margin: 0 auto;">
                <div class="pricing-card">
                    <div class="text-center">
                        <h3 class="pricing-title">Starter</h3>
                        <div class="pricing-price">$5</div>
                        <p class="pricing-description">Perfect for testing and development</p>
                        <ul class="pricing-features">
                            <li>30 days validity</li>
                            <li>2048-bit encryption</li>
                            <li>All formats included</li>
                        </ul>
                        <a href="{{ route('pricing') }}" class="btn btn-primary" style="width: 100%;">Get Started</a>
                    </div>
                </div>

                <div class="pricing-card featured">
                    <div class="pricing-badge">Most Popular</div>
                    <div class="text-center">
                        <h3 class="pricing-title">Professional</h3>
                        <div class="pricing-price">$25</div>
                        <p class="pricing-description">Great for small projects and startups</p>
                        <ul class="pricing-features">
                            <li>180 days validity</li>
                            <li>2048-bit encryption</li>
                            <li>Priority support</li>
                        </ul>
                        <a href="{{ route('pricing') }}" class="btn" style="width: 100%; background: white; color: #3b82f6;">Choose Plan</a>
                    </div>
                </div>

                <div class="pricing-card">
                    <div class="text-center">
                        <h3 class="pricing-title">Enterprise</h3>
                        <div class="pricing-price">$45</div>
                        <p class="pricing-description">Best value for production websites</p>
                        <ul class="pricing-features">
                            <li>365 days validity</li>
                            <li>4096-bit encryption</li>
                            <li>Premium support</li>
                        </ul>
                        <a href="{{ route('pricing') }}" class="btn btn-primary" style="width: 100%;">Get Started</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta">
        <div class="container">
            <h2 class="cta-title">Ready to Secure Your Website?</h2>
            <p class="cta-subtitle">Join thousands of developers and businesses who trust SSLGen for their security needs.</p>
            <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
                <a href="{{ route('register') }}" class="btn btn-secondary btn-large">Start Your Free Trial</a>
                <a href="{{ route('contact') }}" class="btn btn-large" style="background: transparent; border: 2px solid white; color: white;">Contact Sales</a>
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
                        The most trusted platform for SSL certificate generation. Secure your digital presence with enterprise-grade certificates at affordable prices.
                    </p>
                    <div class="social-links">
                        <a href="#" class="social-link">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="social-link">
                            <i class="fab fa-linkedin"></i>
                        </a>
                        <a href="#" class="social-link">
                            <i class="fab fa-github"></i>
                        </a>
                    </div>
                </div>
                <div class="footer-section">
                    <h3>Product</h3>
                    <ul class="footer-links">
                        <li><a href="{{ route('pricing') }}">Pricing</a></li>
                        <li><a href="#">Features</a></li>
                        <li><a href="#">Documentation</a></li>
                        <li><a href="#">API</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h3>Company</h3>
                    <ul class="footer-links">
                        <li><a href="{{ route('contact') }}">Contact</a></li>
                        <li><a href="#">About</a></li>
                        <li><a href="#">Blog</a></li>
                        <li><a href="#">Careers</a></li>
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

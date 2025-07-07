<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Pricing - {{ config('app.name', 'SSL Certificate Generator') }}</title>

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
                <a href="{{ route('pricing') }}" class="nav-link" style="color: #3b82f6; background: rgba(59, 130, 246, 0.1);">Pricing</a>
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

    <!-- Pricing Header -->
    <section class="hero" style="min-height: 60vh;">
        <div class="hero-content slide-in">
            <h1 class="hero-title" style="font-size: 3rem;">SSL Certificate Pricing</h1>
            <p class="hero-subtitle" style="font-size: 1.25rem;">
                Choose the perfect validity period for your SSL certificate
            </p>
        </div>
    </section>

    <!-- Pricing Plans -->
    <section class="section" style="background-color: #f8fafc;">
        <div class="container">
            <div class="grid grid-3">
                <!-- 1 Month Plan -->
                <div class="pricing-card">
                    <div class="text-center">
                        <h3 class="pricing-title">1 Month</h3>
                        <p style="color: #6b7280; margin-bottom: 1rem;">Perfect for testing and development</p>
                        <div class="pricing-price">$5</div>
                        <p style="color: #6b7280; margin-bottom: 2rem;">/certificate</p>
                        <ul class="pricing-features">
                            <li>30 days validity</li>
                            <li>2048-bit encryption</li>
                            <li>Multiple formats (PEM, PFX)</li>
                            <li>Instant generation</li>
                        </ul>
                        @auth
                            <button onclick="selectPlan('1_month', 5, '1 Month SSL Certificate')" class="btn btn-primary" style="width: 100%;">Purchase Now</button>
                        @else
                            <a href="{{ route('register') }}" class="btn btn-primary" style="width: 100%; display: block; text-align: center;">Sign Up to Purchase</a>
                        @endauth
                    </div>
                </div>

                <!-- 6 Months Plan -->
                <div class="pricing-card featured">
                    <div class="pricing-badge">Most Popular</div>
                    <div class="text-center">
                        <h3 class="pricing-title">6 Months</h3>
                        <p style="color: rgba(255, 255, 255, 0.8); margin-bottom: 1rem;">Great for small projects and startups</p>
                        <div class="pricing-price">$25</div>
                        <p style="color: rgba(255, 255, 255, 0.8); margin-bottom: 2rem;">/certificate</p>
                        <ul class="pricing-features">
                            <li>180 days validity</li>
                            <li>2048-bit encryption</li>
                            <li>Multiple formats (PEM, PFX)</li>
                            <li>Priority support</li>
                        </ul>
                        @auth
                            <button onclick="selectPlan('6_months', 25, '6 Months SSL Certificate')" class="btn" style="width: 100%; background: white; color: #3b82f6;">Purchase Now</button>
                        @else
                            <a href="{{ route('register') }}" class="btn" style="width: 100%; background: white; color: #3b82f6; display: block; text-align: center;">Sign Up to Purchase</a>
                        @endauth
                    </div>
                </div>

                <!-- 1 Year Plan -->
                <div class="pricing-card">
                    <div class="text-center">
                        <h3 class="pricing-title">1 Year</h3>
                        <p style="color: #6b7280; margin-bottom: 1rem;">Best value for production websites</p>
                        <div class="pricing-price">$45</div>
                        <p style="color: #6b7280; margin-bottom: 2rem;">/certificate</p>
                        <ul class="pricing-features">
                            <li>365 days validity</li>
                            <li>4096-bit encryption</li>
                            <li>Multiple formats (PEM, PFX)</li>
                            <li>Premium support</li>
                        </ul>
                        @auth
                            <button onclick="selectPlan('1_year', 45, '1 Year SSL Certificate')" class="btn btn-primary" style="width: 100%;">Purchase Now</button>
                        @else
                            <a href="{{ route('register') }}" class="btn btn-primary" style="width: 100%; display: block; text-align: center;">Sign Up to Purchase</a>
                        @endauth
                    </div>
                </div>

                <!-- 2 Years Plan -->
                <div class="pricing-card">
                    <div class="text-center">
                        <h3 class="pricing-title">2 Years</h3>
                        <p style="color: #6b7280; margin-bottom: 1rem;">Long-term security for established sites</p>
                        <div class="pricing-price">$80</div>
                        <p style="color: #6b7280; margin-bottom: 2rem;">/certificate</p>
                        <ul class="pricing-features">
                            <li>730 days validity</li>
                            <li>4096-bit encryption</li>
                            <li>Multiple formats (PEM, PFX)</li>
                            <li>24/7 support</li>
                        </ul>
                        @auth
                            <button onclick="selectPlan('2_years', 80, '2 Years SSL Certificate')" class="btn btn-primary" style="width: 100%;">Purchase Now</button>
                        @else
                            <a href="{{ route('register') }}" class="btn btn-primary" style="width: 100%; display: block; text-align: center;">Sign Up to Purchase</a>
                        @endauth
                    </div>
                </div>

                <!-- 5 Years Plan -->
                <div class="pricing-card">
                    <div class="text-center">
                        <h3 class="pricing-title">5 Years</h3>
                        <p style="color: #6b7280; margin-bottom: 1rem;">Maximum security for enterprise</p>
                        <div class="pricing-price">$200</div>
                        <p style="color: #6b7280; margin-bottom: 2rem;">/certificate</p>
                        <ul class="pricing-features">
                            <li>1825 days validity</li>
                            <li>4096-bit encryption</li>
                            <li>Multiple formats (PEM, PFX)</li>
                            <li>Dedicated support</li>
                        </ul>
                        @auth
                            <button onclick="selectPlan('5_years', 200, '5 Years SSL Certificate')" class="btn btn-primary" style="width: 100%;">Purchase Now</button>
                        @else
                            <a href="{{ route('register') }}" class="btn btn-primary" style="width: 100%; display: block; text-align: center;">Sign Up to Purchase</a>
                        @endauth
                    </div>
                </div>

                <!-- Custom Plan -->
                <div class="pricing-card">
                    <div class="text-center">
                        <h3 class="pricing-title">Custom</h3>
                        <p style="color: #6b7280; margin-bottom: 1rem;">Need a different duration?</p>
                        <div class="pricing-price" style="font-size: 2rem;">Contact Us</div>
                        <ul class="pricing-features">
                            <li>Custom validity period</li>
                            <li>Bulk pricing available</li>
                            <li>Enterprise features</li>
                            <li>Custom support</li>
                        </ul>
                        <a href="{{ route('contact') }}" class="btn" style="width: 100%; background: #6b7280; color: white;">Contact Us</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Payment Modal -->
    <div id="paymentModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Complete Purchase</h3>
                <button onclick="closePaymentModal()" class="modal-close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div id="paymentForm">
                <div class="form-group">
                    <label class="form-label">Certificate Details</label>
                    <p id="certificateDetails" style="color: #6b7280;"></p>
                </div>
                <div class="form-group">
                    <label class="form-label">Amount</label>
                    <p id="certificateAmount" style="font-size: 2rem; font-weight: bold; color: #3b82f6;"></p>
                </div>
                <div class="form-group">
                    <label for="domain" class="form-label">Domain Name *</label>
                    <input type="text" id="domain" name="domain" placeholder="example.com" class="form-input" required>
                </div>
                <div class="form-group">
                    <label for="organization" class="form-label">Organization *</label>
                    <input type="text" id="organization" name="organization" placeholder="Your Company Name" class="form-input" required>
                </div>
                <div class="form-group">
                    <label for="email" class="form-label">Email *</label>
                    <input type="email" id="email" name="email" placeholder="admin@example.com" class="form-input" required>
                </div>
                <div class="form-group">
                    <label for="private_key_password" class="form-label">Private Key Password (Optional)</label>
                    <input type="password" id="private_key_password" name="private_key_password" placeholder="Leave empty for no password" class="form-input">
                    <p style="font-size: 0.75rem; color: #6b7280; margin-top: 0.25rem;">Recommended for security</p>
                </div>
                <div style="display: flex; gap: 1rem;">
                    <button onclick="closePaymentModal()" class="btn" style="flex: 1; background: #e5e7eb; color: #374151;">Cancel</button>
                    <button onclick="initiatePayment()" class="btn btn-primary" style="flex: 1;">Pay Now</button>
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

    <script>
        let selectedPlan = null;
        let selectedAmount = 0;
        let selectedTitle = '';

        function selectPlan(plan, amount, title) {
            selectedPlan = plan;
            selectedAmount = amount;
            selectedTitle = title;
            
            document.getElementById('certificateDetails').textContent = title;
            document.getElementById('certificateAmount').textContent = '$' + amount;
            document.getElementById('paymentModal').classList.add('active');
        }

        function closePaymentModal() {
            document.getElementById('paymentModal').classList.remove('active');
        }

        function initiatePayment() {
            const domain = document.getElementById('domain').value;
            const organization = document.getElementById('organization').value;
            const email = document.getElementById('email').value;
            const privateKeyPassword = document.getElementById('private_key_password').value;

            if (!domain || !organization || !email) {
                alert('Please fill in all required fields');
                return;
            }

            // Create payment data
            const paymentData = {
                plan: selectedPlan,
                amount: selectedAmount,
                title: selectedTitle,
                domain: domain,
                organization: organization,
                email: email,
                private_key_password: privateKeyPassword
            };

            // Send to backend for Flutterwave payment
            fetch('{{ route("payment.initiate") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(paymentData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Redirect to Flutterwave payment page
                    window.location.href = data.payment_url;
                } else {
                    alert('Payment initiation failed: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while initiating payment');
            });
        }

        // Close modal when clicking outside
        document.getElementById('paymentModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closePaymentModal();
            }
        });
    </script>
</body>
</html> 
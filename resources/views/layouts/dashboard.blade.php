<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard') - SSLGen</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <style>
        body { background: #f8fafc; }
        .dashboard-flex {
            display: flex;
            gap: 2.5rem;
            max-width: 1200px;
            margin: 40px auto 0 auto;
            min-height: 70vh;
        }
        .sidebar {
            flex: 0 0 280px;
            background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%);
            color: white;
            border-radius: 18px;
            padding: 2.5rem 1.5rem 2rem 1.5rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            box-shadow: 0 4px 16px rgba(59,130,246,0.10);
            min-height: 500px;
        }
        .profile-avatar {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.7rem;
            color: #3b82f6;
            margin-bottom: 1.2rem;
            box-shadow: 0 2px 8px rgba(59,130,246,0.10);
        }
        .profile-name { font-size: 1.3rem; font-weight: 700; margin-bottom: 0.2rem; }
        .profile-email { font-size: 1rem; opacity: 0.95; margin-bottom: 0.5rem; }
        .profile-role {
            font-size: 0.95rem;
            background: rgba(255,255,255,0.15);
            padding: 0.25rem 0.75rem;
            border-radius: 8px;
            font-weight: 500;
            margin-bottom: 1.5rem;
            text-transform: capitalize;
        }
        .sidebar-links {
            width: 100%;
            margin-top: 1.5rem;
        }
        .sidebar-links a {
            display: block;
            color: #fff;
            background: rgba(255,255,255,0.08);
            border-radius: 8px;
            padding: 0.75rem 1rem;
            margin-bottom: 0.5rem;
            text-decoration: none;
            font-weight: 500;
            transition: background 0.2s;
        }
        .sidebar-links a.active, .sidebar-links a:hover {
            background: #fff;
            color: #3b82f6;
        }
        .main-content {
            flex: 1;
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 10px 32px rgba(59,130,246,0.08);
            padding: 2.5rem 2rem;
            min-width: 0;
        }
        @media (max-width: 900px) {
            .dashboard-flex { flex-direction: column; gap: 1.5rem; padding: 0 5px; }
            .sidebar { min-height: 0; margin-bottom: 1.5rem; }
        }
        @media (max-width: 600px) {
            .main-content { padding: 1.2rem 0.5rem; }
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
                <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" style="color: #3b82f6; border-bottom: 2px solid #3b82f6;">Dashboard</a>
                <div style="display: inline-block; position: relative;">
                    <a href="#" class="nav-link" style="font-weight: 600;">{{ Auth::user()->name }} <i class="fas fa-caret-down"></i></a>
                    <div class="profile-dropdown" style="display: none; position: absolute; right: 0; background: #fff; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); min-width: 150px; z-index: 10;">
                        <a href="{{ route('profile.edit') }}" style="display: block; padding: 10px 16px; color: #374151; text-decoration: none;">Profile</a>
                        <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                            @csrf
                            <button type="submit" style="width: 100%; background: none; border: none; color: #374151; padding: 10px 16px; text-align: left; cursor: pointer;">Log Out</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="dashboard-flex">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="profile-avatar"><i class="fas fa-user"></i></div>
            <div class="profile-name">{{ Auth::user()->name }}</div>
            <div class="profile-email">{{ Auth::user()->email }}</div>
            <div class="profile-role">{{ Auth::user()->user_type ?? 'user' }}</div>
            <div class="sidebar-links">
                <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}"><i class="fas fa-home"></i> Overview</a>
                <a href="{{ route('profile.edit') }}" class="{{ request()->routeIs('profile.edit') ? 'active' : '' }}"><i class="fas fa-user-edit"></i> Edit Profile</a>
                <a href="{{ route('password.change') }}" class="{{ request()->routeIs('password.change') ? 'active' : '' }}"><i class="fas fa-key"></i> Change Password</a>
                <a href="{{ route('ssl-certificates.index') }}" class="{{ request()->is('ssl-certificates*') ? 'active' : '' }}"><i class="fas fa-certificate"></i> My SSL Certificates</a>
            </div>
        </div>
        <!-- Main Content -->
        <div class="main-content">
            @yield('content')
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
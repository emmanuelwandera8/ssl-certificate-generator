@extends('layouts.dashboard')
@section('title', 'Dashboard')
@section('content')
    <div class="dashboard-title">Welcome, {{ Auth::user()->name }}!</div>
    <div class="dashboard-welcome">Manage your SSL certificates, update your profile, and keep your account secure.</div>
    <div class="ssl-summary">
        <div class="ssl-summary-card">
            <div class="count">{{ Auth::user()->ssl_certificates_count ?? 0 }}</div>
            <div class="label">Certificates</div>
        </div>
        <div class="ssl-summary-card ssl-summary-card-green">
            <div class="count">{{ Auth::user()->ssl_certificates_active ?? 0 }}</div>
            <div class="label">Active</div>
        </div>
    </div>
    <div class="dashboard-cta">
        <a href="{{ route('ssl-certificates.index') }}" class="btn btn-primary">
            <i class="fas fa-certificate"></i>
            Manage SSL Certificates
        </a>
    </div>
@endsection

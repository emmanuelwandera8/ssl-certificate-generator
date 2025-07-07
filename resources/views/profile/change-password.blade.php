@extends('layouts.dashboard')
@section('title', 'Change Password')
@section('content')
    <div class="section-title">Change Password</div>
    <div class="card">
        @include('profile.partials.update-password-form')
    </div>
@endsection 
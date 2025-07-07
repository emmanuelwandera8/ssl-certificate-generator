@extends('layouts.dashboard')
@section('title', 'Edit Profile')
@section('content')
    <div class="section-title">Edit Profile</div>
    <div class="card">
        @include('profile.partials.update-profile-information-form')
    </div>
@endsection

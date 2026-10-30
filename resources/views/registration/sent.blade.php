@extends('layouts.app')

@section('title', 'Check your email')
@section('subtitle', 'Registration Received')

@section('content')
    <div class="message">
        <div class="icon">📧</div>
        <h2>Check your email</h2>
        @if ($bookingCode)
            <p>Booking code: <strong>{{ $bookingCode }}</strong></p>
        @endif
        <p>We sent your ticket details to<br><strong>{{ $email }}</strong>.</p>
        <p>Open the email and click <strong>Confirm My Registration</strong> within
            {{ config('concert.confirm_days') }} days to secure your tickets.</p>
        <p class="muted">Can't find it? Check your Spam or Junk folder.</p>
    </div>

    <a href="{{ route('registration.create') }}" class="btn">Back to registration form</a>
@endsection

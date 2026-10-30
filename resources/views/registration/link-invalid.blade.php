@extends('layouts.app')

@section('title', 'Link expired')
@section('subtitle', 'Registration Confirmation')

@section('content')
    <div class="message">
        <div class="icon">⏰</div>
        <h2>This link is invalid or has expired</h2>
        <p>Confirmation links are valid for {{ config('concert.confirm_days') }} days.
            Please contact <a href="mailto:{{ config('concert.contact_email') }}">{{ config('concert.contact_email') }}</a>
            if you still need your tickets.</p>
    </div>

    <a href="{{ route('registration.create') }}" class="btn">Back to registration form</a>
@endsection

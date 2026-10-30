@extends('layouts.app')

@section('title', 'Check your inbox')

@section('content')
    <div class="notice">
        <h2>Check your inbox</h2>
        <p>Your registration is in. We sent the booking details to <strong>{{ $email }}</strong>.</p>

        @if ($bookingCode)
            <div class="code-stub">
                <span>Booking code</span>
                <strong>{{ $bookingCode }}</strong>
            </div>
        @endif

        <p>Open the email and press <strong>Confirm My Registration</strong> within
            {{ config('concert.confirm_days') }} days, or the tickets are released.</p>
        <p class="hint">No email after a few minutes? Look in Spam or Junk.</p>
    </div>

    <a href="{{ route('registration.create') }}" class="btn btn-quiet">Register another booking</a>
@endsection

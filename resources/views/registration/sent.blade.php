@extends('layouts.app')

@section('title', 'Check your inbox')

@section('content')
    <div class="notice">
        <h2>Check your inbox</h2>
        <p>Your registration is in. The booking details were sent to <strong>{{ $email }}</strong>.</p>
    </div>

    @if ($bookingCode)
        <div class="details">
            <div class="row last">
                <span class="label">Booking code</span>
                <h3>{{ $bookingCode }}</h3>
            </div>
        </div>
    @endif

    <div class="notice">
        <p>Open the email and press <strong>Confirm My Registration</strong> within
            {{ config('concert.confirm_days') }} days, or the tickets are released.</p>
        <p class="hint">No email after a few minutes? Look in Spam or Junk.</p>
    </div>

    <a href="{{ route('registration.create') }}" class="button solid">Register another booking</a>
@endsection

@extends('layouts.app')

@section('title', 'Registration confirmed')

@section('content')
    <div class="notice">
        @if ($alreadyConfirmed)
            <h2>Already confirmed</h2>
            <p>{{ $registration->full_name }}, this booking was confirmed on
                {{ $registration->confirmed_at->format('F j, Y') }}. Nothing else to do.</p>
        @else
            <h2>Registration confirmed</h2>
            <p>Thank you, {{ $registration->full_name }}. Your booking is confirmed. See you at the show.</p>
        @endif
    </div>

    <div class="details">
        <div class="row">
            <span class="label">Booking code</span>
            <h3>{{ $registration->booking_code }}</h3>
        </div>
        <div class="row">
            <span class="label">Ticket</span>
            <span>{{ $registration->quantity }} × {{ $registration->ticketLabel() }}</span>
        </div>
        <div class="row">
            <span class="label">Total</span>
            <strong>{{ \App\Models\Registration::rupiah($registration->total_price) }}</strong>
        </div>
        <div class="row last">
            <span class="label">Email</span>
            <span>{{ $registration->email }}</span>
        </div>
    </div>

    <p class="hint">Show the booking code at the entrance.</p>
@endsection

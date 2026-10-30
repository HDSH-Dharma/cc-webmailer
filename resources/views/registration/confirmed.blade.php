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

        <div class="code-stub">
            <span>{{ $registration->quantity }} × {{ $registration->ticketLabel() }}</span>
            <strong>{{ $registration->booking_code }}</strong>
        </div>

        <p>Total: <strong>{{ \App\Models\Registration::rupiah($registration->total_price) }}</strong>.
            Show the booking code at the entrance.</p>
        <p class="hint">Sent to {{ $registration->email }}</p>
    </div>
@endsection

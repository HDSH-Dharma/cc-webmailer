@extends('layouts.app')

@section('title', 'Registration confirmed')
@section('subtitle', 'Registration Confirmed')

@section('content')
    <div class="message">
        <div class="icon">🎫</div>
        @if ($alreadyConfirmed)
            <h2>Already confirmed</h2>
            <p>Hi <strong>{{ $registration->full_name }}</strong>, booking
                <strong>{{ $registration->booking_code }}</strong> was already confirmed on
                {{ $registration->confirmed_at->format('F j, Y') }}.</p>
        @else
            <h2>See you at the show!</h2>
            <p>Thank you, <strong>{{ $registration->full_name }}</strong>. Your booking
                <strong>{{ $registration->booking_code }}</strong> is confirmed.</p>
        @endif
        <p>{{ $registration->quantity }} × {{ $registration->ticketLabel() }}<br>
            Total: <strong>{{ \App\Models\Registration::rupiah($registration->total_price) }}</strong></p>
        <p class="muted">{{ $registration->email }}</p>
    </div>
@endsection

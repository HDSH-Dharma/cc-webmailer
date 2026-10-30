@extends('layouts.app')

@section('title', 'Link expired')

@section('content')
    <div class="notice">
        <h2>This link is invalid or has expired</h2>
        <p>Confirmation links work for {{ config('concert.confirm_days') }} days after you register.
            Register again to get a new link, or email
            <a href="mailto:{{ config('concert.contact_email') }}">{{ config('concert.contact_email') }}</a> for help.</p>
    </div>

    <a href="{{ route('registration.create') }}" class="btn">Register again</a>
@endsection

@extends('layouts.app')

@section('hero')
    <section class="hero">
        <div class="wrap">
            <h1>{{ config('concert.name') }}</h1>
            <p>{{ config('concert.tagline') }}</p>
            <dl class="facts">
                <div><dt>When</dt><dd>{{ config('concert.date') }}</dd></div>
                <div><dt>Where</dt><dd>{{ config('concert.venue') }}</dd></div>
            </dl>
            <a class="button" href="#tickets">Get tickets</a>
        </div>
    </section>
@endsection

@section('content')
    <h2>Get your tickets</h2>
    <p class="intro">Fill in your details. Your booking and a confirmation link are emailed to you right away.</p>

    @error('mail')
        <div class="alert" role="alert">{{ $message }}</div>
    @enderror

    <form method="POST" action="{{ route('registration.store') }}" novalidate>
        @csrf

        <div class="row">
            <label for="full_name">Full name</label>
            <div class="control">
                <input type="text" id="full_name" name="full_name" value="{{ old('full_name') }}"
                       placeholder="As written on your ID" autocomplete="name" required
                       @class(['is-invalid' => $errors->has('full_name')])>
                @error('full_name') <p class="error">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="row">
            <label for="email">Email</label>
            <div class="control">
                <input type="email" id="email" name="email" value="{{ old('email') }}"
                       placeholder="you@example.com" autocomplete="email" required aria-describedby="email-hint"
                       @class(['is-invalid' => $errors->has('email')])>
                @error('email')
                    <p class="error">{{ $message }}</p>
                @else
                    <p class="hint" id="email-hint">Your booking details go to this address.</p>
                @enderror
            </div>
        </div>

        <div class="row">
            <label for="password">Password</label>
            <div class="control">
                <input type="password" id="password" name="password"
                       placeholder="At least 8 characters" autocomplete="new-password" required
                       @class(['is-invalid' => $errors->has('password')])>
                @error('password') <p class="error">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="row">
            <label for="password_confirmation">Confirm password</label>
            <div class="control">
                <input type="password" id="password_confirmation" name="password_confirmation"
                       placeholder="Type it again" autocomplete="new-password" required>
            </div>
        </div>

        <div class="row">
            <label for="birthdate">Birthdate</label>
            <div class="control">
                <input type="date" id="birthdate" name="birthdate" value="{{ old('birthdate') }}"
                       max="{{ now()->subDay()->toDateString() }}" required
                       @class(['is-invalid' => $errors->has('birthdate')])>
                @error('birthdate') <p class="error">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="row">
            <span class="label" id="ticket-label">Ticket</span>
            <div class="control">
                <fieldset class="tiers" aria-labelledby="ticket-label">
                    @foreach ($tickets as $key => $ticket)
                        <label class="tier">
                            <input type="radio" name="ticket_category" value="{{ $key }}" data-price="{{ $ticket['price'] }}"
                                   @checked(old('ticket_category', 'festival') === $key)>
                            <span class="box">
                                <span>
                                    <span class="name">{{ $ticket['label'] }}</span>
                                    <span class="perk">{{ $ticket['perk'] ?? '' }}</span>
                                </span>
                                <span class="price">{{ \App\Models\Registration::rupiah($ticket['price']) }}</span>
                            </span>
                        </label>
                    @endforeach
                </fieldset>
                @error('ticket_category') <p class="error">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="row last">
            <label for="quantity">Quantity</label>
            <div class="control qty">
                <div>
                    <input type="number" id="quantity" name="quantity" min="1" max="{{ $maxQuantity }}"
                           value="{{ old('quantity', 1) }}" inputmode="numeric" required
                           @class(['is-invalid' => $errors->has('quantity')])>
                    @error('quantity')
                        <p class="error">{{ $message }}</p>
                    @else
                        <p class="hint">Up to {{ $maxQuantity }} per booking</p>
                    @enderror
                </div>
                <div class="total">
                    <small>Total</small>
                    <output id="total" for="quantity" aria-live="polite">–</output>
                </div>
            </div>
        </div>

        <button type="submit" class="button solid">Register</button>
        <p class="fine">Tickets are held for {{ config('concert.confirm_days') }} days until you confirm from the email.</p>
    </form>

    <script>
        (() => {
            const max = {{ $maxQuantity }};
            const qty = document.getElementById('quantity');
            const total = document.getElementById('total');
            const rupiah = n => 'Rp ' + n.toLocaleString('id-ID');

            function update() {
                const tier = document.querySelector('input[name="ticket_category"]:checked');
                const n = Math.min(Math.max(parseInt(qty.value, 10) || 0, 0), max);
                total.textContent = tier && n > 0 ? rupiah(Number(tier.dataset.price) * n) : '–';
            }

            qty.addEventListener('input', update);
            document.querySelectorAll('input[name="ticket_category"]').forEach(r => r.addEventListener('change', update));
            update();
        })();
    </script>
@endsection

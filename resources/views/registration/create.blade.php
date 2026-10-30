@extends('layouts.app')

@section('content')
    <h2>Get your tickets</h2>
    <p class="lede">Fill in your details and we'll email your booking right away.</p>

    @error('mail')
        <div class="alert" role="alert">{{ $message }}</div>
    @enderror

    <form method="POST" action="{{ route('registration.store') }}" novalidate>
        @csrf

        <div class="field">
            <label for="full_name">Full name</label>
            <input type="text" id="full_name" name="full_name" value="{{ old('full_name') }}"
                   placeholder="As written on your ID" autocomplete="name" required
                   @class(['is-invalid' => $errors->has('full_name')])>
            @error('full_name') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="field">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}"
                   placeholder="you@example.com" autocomplete="email" required aria-describedby="email-hint"
                   @class(['is-invalid' => $errors->has('email')])>
            @error('email')
                <div class="error">{{ $message }}</div>
            @else
                <div class="hint" id="email-hint">Your booking details and confirmation link go to this address.</div>
            @enderror
        </div>

        <div class="pair">
            <div class="field">
                <label for="password">Password</label>
                <input type="password" id="password" name="password"
                       placeholder="At least 8 characters" autocomplete="new-password" required
                       @class(['is-invalid' => $errors->has('password')])>
                @error('password') <div class="error">{{ $message }}</div> @enderror
            </div>

            <div class="field">
                <label for="password_confirmation">Confirm password</label>
                <input type="password" id="password_confirmation" name="password_confirmation"
                       placeholder="Type it again" autocomplete="new-password" required>
            </div>
        </div>

        <div class="field">
            <label for="birthdate">Birthdate</label>
            <input type="date" id="birthdate" name="birthdate" value="{{ old('birthdate') }}"
                   max="{{ now()->subDay()->toDateString() }}" required
                   @class(['is-invalid' => $errors->has('birthdate')])>
            @error('birthdate') <div class="error">{{ $message }}</div> @enderror
        </div>

        <fieldset>
            <legend class="legend">Ticket</legend>
            <div class="tiers">
                @foreach ($tickets as $key => $ticket)
                    <label class="tier">
                        <input type="radio" name="ticket_category" value="{{ $key }}" data-price="{{ $ticket['price'] }}"
                               @checked(old('ticket_category', 'festival') === $key)>
                        <span class="stub">
                            <span class="name">{{ $ticket['label'] }}</span>
                            <span class="price">{{ \App\Models\Registration::rupiah($ticket['price']) }}</span>
                            <span class="perk">{{ $ticket['perk'] ?? '' }}</span>
                        </span>
                    </label>
                @endforeach
            </div>
            @error('ticket_category') <div class="error">{{ $message }}</div> @enderror
        </fieldset>

        <div class="order">
            <div>
                <label for="quantity">How many?</label>
                <div class="stepper">
                    <button type="button" data-step="-1" aria-label="One ticket fewer">−</button>
                    <input type="number" id="quantity" name="quantity" min="1" max="{{ $maxQuantity }}"
                           value="{{ old('quantity', 1) }}" inputmode="numeric" required>
                    <button type="button" data-step="1" aria-label="One ticket more">+</button>
                </div>
                @error('quantity') <div class="error">{{ $message }}</div> @enderror
            </div>
            <div class="total">
                <small>Total</small>
                <output id="total" for="quantity" aria-live="polite">–</output>
            </div>
        </div>

        <button type="submit" class="btn">Register</button>
        <p class="fine">Tickets are held for {{ config('concert.confirm_days') }} days until you confirm from the email.
            Up to {{ $maxQuantity }} tickets per booking.</p>
    </form>

    <script>
        (() => {
            const max = {{ $maxQuantity }};
            const qty = document.getElementById('quantity');
            const total = document.getElementById('total');
            const minus = document.querySelector('[data-step="-1"]');
            const plus = document.querySelector('[data-step="1"]');
            const rupiah = n => 'Rp ' + n.toLocaleString('id-ID');

            function clamp(n) { return Math.min(Math.max(n || 1, 1), max); }

            function update() {
                const tier = document.querySelector('input[name="ticket_category"]:checked');
                const n = clamp(parseInt(qty.value, 10));
                minus.disabled = n <= 1;
                plus.disabled = n >= max;
                total.textContent = tier ? rupiah(Number(tier.dataset.price) * n) : '–';
            }

            document.querySelectorAll('[data-step]').forEach(btn => btn.addEventListener('click', () => {
                qty.value = clamp(parseInt(qty.value, 10) + Number(btn.dataset.step));
                update();
            }));
            qty.addEventListener('input', update);
            qty.addEventListener('blur', () => { qty.value = clamp(parseInt(qty.value, 10)); update(); });
            document.querySelectorAll('input[name="ticket_category"]').forEach(r => r.addEventListener('change', update));
            update();
        })();
    </script>
@endsection

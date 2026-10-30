@extends('layouts.app')

@section('content')
    @error('mail')
        <div class="alert">{{ $message }}</div>
    @enderror

    <form method="POST" action="{{ route('registration.store') }}" novalidate>
        @csrf

        <div class="field">
            <label for="full_name">Full Name</label>
            <input type="text" id="full_name" name="full_name" value="{{ old('full_name') }}"
                   placeholder="Enter your full name" autocomplete="name" required
                   @class(['is-invalid' => $errors->has('full_name')])>
            @error('full_name') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="field">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}"
                   placeholder="Enter your email (the ticket details are sent here)" autocomplete="email" required
                   @class(['is-invalid' => $errors->has('email')])>
            @error('email') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="field">
            <label for="password">Password</label>
            <input type="password" id="password" name="password"
                   placeholder="Create a secure password" autocomplete="new-password" required
                   @class(['is-invalid' => $errors->has('password')])>
            @error('password') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="field">
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation"
                   placeholder="Confirm your password" autocomplete="new-password" required>
        </div>

        <div class="field">
            <label for="birthdate">Birthdate</label>
            <input type="date" id="birthdate" name="birthdate" value="{{ old('birthdate') }}"
                   max="{{ now()->subDay()->toDateString() }}" required
                   @class(['is-invalid' => $errors->has('birthdate')])>
            @error('birthdate') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="row">
            <div class="field">
                <label for="ticket_category">Ticket Category</label>
                <select id="ticket_category" name="ticket_category" required
                        @class(['is-invalid' => $errors->has('ticket_category')])>
                    @foreach ($tickets as $key => $ticket)
                        <option value="{{ $key }}" data-price="{{ $ticket['price'] }}"
                                @selected(old('ticket_category', 'festival') === $key)>
                            {{ $ticket['label'] }} – {{ \App\Models\Registration::rupiah($ticket['price']) }}
                        </option>
                    @endforeach
                </select>
                @error('ticket_category') <div class="error">{{ $message }}</div> @enderror
            </div>

            <div class="field qty">
                <label for="quantity">Quantity</label>
                <input type="number" id="quantity" name="quantity" min="1" max="{{ $maxQuantity }}"
                       value="{{ old('quantity', 1) }}" required
                       @class(['is-invalid' => $errors->has('quantity')])>
                @error('quantity') <div class="error">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="total">
            <span>Total</span>
            <strong id="total">–</strong>
        </div>

        <button type="submit" class="btn">Register for {{ config('concert.name') }}</button>
    </form>

    <script>
        (() => {
            const category = document.getElementById('ticket_category');
            const quantity = document.getElementById('quantity');
            const total = document.getElementById('total');
            const rupiah = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 });

            function update() {
                const price = Number(category.selectedOptions[0]?.dataset.price || 0);
                const qty = Math.min(Math.max(parseInt(quantity.value, 10) || 0, 0), {{ $maxQuantity }});
                total.textContent = qty > 0 ? rupiah.format(price * qty) : '–';
            }

            category.addEventListener('change', update);
            quantity.addEventListener('input', update);
            update();
        })();
    </script>
@endsection

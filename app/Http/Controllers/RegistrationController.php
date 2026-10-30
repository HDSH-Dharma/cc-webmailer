<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRegistrationRequest;
use App\Mail\RegistrationConfirmation;
use App\Models\Registration;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Throwable;

class RegistrationController extends Controller
{
    /**
     * Show the ticket registration form.
     */
    public function create(): View
    {
        return view('registration.create', [
            'tickets' => config('concert.tickets'),
            'maxQuantity' => (int) config('concert.max_quantity'),
        ]);
    }

    /**
     * Save the registration and email the details to the address typed in the form.
     *
     * The insert and the email run in one transaction: if the mail server
     * rejects the message, nothing is saved and the user can simply try again.
     */
    public function store(StoreRegistrationRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $quantity = (int) $data['quantity'];
        $unitPrice = (int) config("concert.tickets.{$data['ticket_category']}.price");

        try {
            $registration = DB::transaction(function () use ($data, $quantity, $unitPrice) {
                $registration = Registration::create([
                    'booking_code' => Registration::newBookingCode(),
                    'full_name' => $data['full_name'],
                    'email' => $data['email'],
                    'password' => $data['password'],
                    'birthdate' => $data['birthdate'],
                    'event' => config('concert.name'),
                    'ticket_category' => $data['ticket_category'],
                    'quantity' => $quantity,
                    'total_price' => $quantity * $unitPrice,
                ]);

                $mail = Mail::to($registration->email, $registration->full_name);

                if ($bcc = config('concert.bcc_email')) {
                    $mail->bcc($bcc);
                }

                $mail->send(new RegistrationConfirmation($registration));

                return $registration;
            });
        } catch (Throwable $e) {
            report($e);

            $message = 'We could not send the confirmation email. Please try again in a moment.';

            if (config('app.debug')) {
                $message .= ' ['.$e->getMessage().']';
            }

            return back()
                ->withInput($request->except('password', 'password_confirmation'))
                ->withErrors(['mail' => $message]);
        }

        return redirect()
            ->route('registration.sent')
            ->with('registered_email', $registration->email)
            ->with('booking_code', $registration->booking_code);
    }

    /**
     * "Check your inbox" page shown right after a successful submit.
     */
    public function sent(Request $request): View|RedirectResponse
    {
        $email = $request->session()->get('registered_email');

        if (! $email) {
            return redirect()->route('registration.create');
        }

        return view('registration.sent', [
            'email' => $email,
            'bookingCode' => $request->session()->get('booking_code'),
        ]);
    }

    /**
     * Target of the "Confirm My Registration" button (signed, expires after N days).
     */
    public function confirm(Registration $registration): View
    {
        $alreadyConfirmed = $registration->isConfirmed();

        if (! $alreadyConfirmed) {
            $registration->forceFill(['confirmed_at' => now()])->save();
        }

        return view('registration.confirmed', [
            'registration' => $registration,
            'alreadyConfirmed' => $alreadyConfirmed,
        ]);
    }
}

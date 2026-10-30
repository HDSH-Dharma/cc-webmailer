<?php

namespace App\Mail;

use App\Models\Registration;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

/**
 * Sent synchronously (not queued) so no queue worker is needed on the server.
 */
class RegistrationConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Registration $registration)
    {
        //
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Ticket Registration Confirmation - '.$this->registration->event
                .' ['.$this->registration->booking_code.']',
        );
    }

    public function content(): Content
    {
        $days = (int) config('concert.confirm_days', 7);

        return new Content(
            view: 'emails.registration-confirmation',
            text: 'emails.registration-confirmation-text',
            with: [
                'confirmUrl' => URL::temporarySignedRoute(
                    'registration.confirm',
                    now()->addDays($days),
                    ['registration' => $this->registration->getKey()],
                ),
                'days' => $days,
                'eventDate' => config('concert.date'),
                'eventVenue' => config('concert.venue'),
                'contactEmail' => config('concert.contact_email'),
            ],
        );
    }
}

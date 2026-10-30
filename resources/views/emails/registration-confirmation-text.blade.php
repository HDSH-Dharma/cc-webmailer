{!! $registration->event !!} - Ticket Registration Confirmation

Hello {!! $registration->full_name !!}!

Congratulations! You have successfully registered for tickets to {!! $registration->event !!}. We can't wait to see you at the show!

Registration Details
- Booking Code: {!! $registration->booking_code !!}
- Full Name: {!! $registration->full_name !!}
- Email: {!! $registration->email !!}
- Birthdate: {!! $registration->birthdate->format('F j, Y') !!}
- Event: {!! $registration->event !!}
- Date: {!! $eventDate !!}
- Venue: {!! $eventVenue !!}
- Ticket: {!! $registration->quantity !!} x {!! $registration->ticketLabel() !!} ({!! \App\Models\Registration::rupiah($registration->unitPrice()) !!} each)
- Total: {!! \App\Models\Registration::rupiah($registration->total_price) !!}

To complete your registration and secure your tickets, open this link:
{!! $confirmUrl !!}

Important: Please confirm your registration within {!! $days !!} days to secure your tickets.

Thank you for choosing {!! $registration->event !!}!
If you have any questions, please contact us at {!! $contactEmail !!}

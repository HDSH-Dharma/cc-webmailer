<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $registration->event }} - Ticket Registration Confirmation</title>
</head>
<body style="margin:0; padding:0; background-color:#ffffff; font-family:Arial, Helvetica, sans-serif; color:#222222;">
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#ffffff;">
    <tr>
        <td align="center" style="padding:28px 16px;">
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="max-width:600px;">

                {{-- Header --}}
                <tr>
                    <td align="center" style="padding-bottom:22px;">
                        <div style="font-size:22px; font-weight:bold; color:#2e1065;">🎵 {{ $registration->event }}</div>
                        <div style="font-size:12px; color:#8a8f98; margin-top:6px;">Ticket Registration Confirmation</div>
                    </td>
                </tr>

                {{-- Greeting --}}
                <tr>
                    <td style="font-size:15px; line-height:1.5; padding-bottom:8px;">
                        Hello <strong>{{ $registration->full_name }}</strong>!
                    </td>
                </tr>
                <tr>
                    <td style="font-size:13px; line-height:1.6; padding-bottom:16px;">
                        Congratulations! You have successfully registered for tickets to <strong>{{ $registration->event }}</strong>.
                        We can't wait to see you at the show!
                    </td>
                </tr>

                {{-- Registration details --}}
                <tr>
                    <td style="background-color:#f6f7f9; border-radius:6px; padding:16px 18px;">
                        <div style="font-size:13px; font-weight:bold; margin-bottom:10px;">📋 Registration Details</div>
                        <table role="presentation" cellpadding="0" cellspacing="0" border="0" style="font-size:12px; line-height:1.5;">
                            @php
                                $label = 'padding:3px 28px 3px 0; color:#444444; font-weight:bold; white-space:nowrap; vertical-align:top;';
                                $value = 'padding:3px 0;';
                            @endphp
                            <tr>
                                <td style="{{ $label }}">Booking Code:</td>
                                <td style="{{ $value }}"><strong style="letter-spacing:1px;">{{ $registration->booking_code }}</strong></td>
                            </tr>
                            <tr>
                                <td style="{{ $label }}">Full Name:</td>
                                <td style="{{ $value }}">{{ $registration->full_name }}</td>
                            </tr>
                            <tr>
                                <td style="{{ $label }}">Email:</td>
                                <td style="{{ $value }}"><a href="mailto:{{ $registration->email }}" style="color:#1a56db;">{{ $registration->email }}</a></td>
                            </tr>
                            <tr>
                                <td style="{{ $label }}">Birthdate:</td>
                                <td style="{{ $value }}">{{ $registration->birthdate->format('F j, Y') }}</td>
                            </tr>
                            <tr>
                                <td style="{{ $label }}">Event:</td>
                                <td style="{{ $value }}"><strong>{{ $registration->event }}</strong></td>
                            </tr>
                            <tr>
                                <td style="{{ $label }}">Date:</td>
                                <td style="{{ $value }}">{{ $eventDate }}</td>
                            </tr>
                            <tr>
                                <td style="{{ $label }}">Venue:</td>
                                <td style="{{ $value }}">{{ $eventVenue }}</td>
                            </tr>
                            <tr>
                                <td style="{{ $label }}">Ticket:</td>
                                <td style="{{ $value }}">{{ $registration->quantity }} × {{ $registration->ticketLabel() }}
                                    ({{ \App\Models\Registration::rupiah($registration->unitPrice()) }} each)</td>
                            </tr>
                            <tr>
                                <td style="{{ $label }}">Total:</td>
                                <td style="{{ $value }}"><strong>{{ \App\Models\Registration::rupiah($registration->total_price) }}</strong></td>
                            </tr>
                        </table>
                    </td>
                </tr>

                {{-- Call to action --}}
                <tr>
                    <td style="font-size:13px; line-height:1.6; padding:20px 0 14px;">
                        To complete your registration and secure your tickets, please click the button below:
                    </td>
                </tr>
                <tr>
                    <td align="center" style="padding-bottom:18px;">
                        <table role="presentation" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td align="center" bgcolor="#5cb85c" style="border-radius:5px;">
                                    <a href="{{ $confirmUrl }}" target="_blank"
                                       style="display:inline-block; padding:11px 26px; font-size:14px; font-weight:bold; color:#ffffff; text-decoration:none; border-radius:5px; background-color:#5cb85c;">
                                        🎫 Confirm My Registration
                                    </a>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="font-size:12px; line-height:1.6; padding-bottom:18px;">
                        <strong>Important:</strong> Please confirm your registration within {{ $days }} days to secure your tickets.
                    </td>
                </tr>
                <tr>
                    <td style="font-size:11px; line-height:1.6; color:#8a8f98; padding-bottom:18px;">
                        Button not working? Copy this link into your browser:<br>
                        <a href="{{ $confirmUrl }}" style="color:#1a56db; word-break:break-all;">{{ $confirmUrl }}</a>
                    </td>
                </tr>

                {{-- Footer --}}
                <tr>
                    <td style="border-top:1px solid #e5e7eb; padding-top:16px; text-align:center; font-size:11px; line-height:1.7; color:#8a8f98;">
                        Thank you for choosing {{ $registration->event }}!<br>
                        If you have any questions, please contact us at
                        <a href="mailto:{{ $contactEmail }}" style="color:#1a56db;">{{ $contactEmail }}</a>
                    </td>
                </tr>

            </table>
        </td>
    </tr>
</table>
</body>
</html>

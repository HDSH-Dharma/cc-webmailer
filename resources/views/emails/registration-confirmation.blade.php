<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="color-scheme" content="light">
    <title>Your {{ $registration->event }} booking</title>
</head>
<body style="margin:0; padding:0; background-color:#f6f2f2; font-family:system-ui, -apple-system, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; color:#231f1f;">
@php
    $serif = "font-family:'Iowan Old Style', 'Palatino Linotype', Palatino, Georgia, serif;";
    $label = 'padding:12px 16px 12px 0; border-top:1px solid #e4dcdc; font-size:14px; color:#6b6262; white-space:nowrap; vertical-align:top; width:120px;';
    $value = 'padding:12px 0; border-top:1px solid #e4dcdc; font-size:15px; color:#231f1f;';
@endphp
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#f6f2f2;">
    <tr>
        <td align="center" style="padding:32px 14px;">
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="max-width:600px; background-color:#ffffff;">

                {{-- Maroon header, like the website --}}
                <tr>
                    <td bgcolor="#800000" style="background-color:#800000; padding:36px 32px 34px;">
                        <div style="{{ $serif }} font-size:32px; line-height:1.15; font-weight:bold; color:#ffffff;">{{ $registration->event }}</div>
                        <div style="padding-top:12px; font-size:15px; line-height:1.6; color:#f1e3e3;">
                            {{ $eventDate }}<br>{{ $eventVenue }}
                        </div>
                    </td>
                </tr>
                <tr>
                    <td bgcolor="#004d40" style="background-color:#004d40; height:6px; line-height:6px; font-size:0;">&nbsp;</td>
                </tr>

                {{-- Greeting --}}
                <tr>
                    <td style="padding:30px 32px 6px;">
                        <div style="{{ $serif }} font-size:22px; font-weight:bold; color:#800000;">Hello {{ $registration->full_name }}!</div>
                        <p style="margin:12px 0 0; font-size:15px; line-height:1.65; color:#231f1f;">
                            Congratulations! You have successfully registered for tickets to
                            <strong>{{ $registration->event }}</strong>. Here are your registration details.
                        </p>
                    </td>
                </tr>

                {{-- Registration details --}}
                <tr>
                    <td style="padding:20px 32px 8px;">
                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td style="{{ $label }}">Booking code</td>
                                <td style="{{ $value }} {{ $serif }} font-size:20px; font-weight:bold; letter-spacing:1px; color:#800000;">{{ $registration->booking_code }}</td>
                            </tr>
                            <tr><td style="{{ $label }}">Full name</td><td style="{{ $value }}">{{ $registration->full_name }}</td></tr>
                            <tr><td style="{{ $label }}">Email</td><td style="{{ $value }}"><a href="mailto:{{ $registration->email }}" style="color:#231f1f;">{{ $registration->email }}</a></td></tr>
                            <tr><td style="{{ $label }}">Birthdate</td><td style="{{ $value }}">{{ $registration->birthdate->format('F j, Y') }}</td></tr>
                            <tr><td style="{{ $label }}">Ticket</td><td style="{{ $value }}">{{ $registration->quantity }} × {{ $registration->ticketLabel() }} ({{ \App\Models\Registration::rupiah($registration->unitPrice()) }} each)</td></tr>
                            <tr>
                                <td style="{{ $label }} border-bottom:1px solid #e4dcdc;">Total</td>
                                <td style="{{ $value }} border-bottom:1px solid #e4dcdc; font-weight:bold;">{{ \App\Models\Registration::rupiah($registration->total_price) }}</td>
                            </tr>
                        </table>
                    </td>
                </tr>

                {{-- Call to action --}}
                <tr>
                    <td style="padding:22px 32px 6px;">
                        <p style="margin:0 0 20px; font-size:15px; line-height:1.65;">
                            To complete your registration and secure your tickets, press the button below.
                        </p>
                        <table role="presentation" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td align="center" bgcolor="#800000" style="border-radius:999px;">
                                    <a href="{{ $confirmUrl }}" target="_blank"
                                       style="display:inline-block; padding:13px 30px; font-size:16px; font-weight:bold; color:#ffffff; text-decoration:none; border-radius:999px; background-color:#800000;">
                                        Confirm My Registration
                                    </a>
                                </td>
                            </tr>
                        </table>
                        <p style="margin:20px 0 0; font-size:14px; line-height:1.65; color:#231f1f;">
                            <strong>Important:</strong> please confirm within {{ $days }} days, or the tickets are released.
                        </p>
                    </td>
                </tr>

                <tr>
                    <td style="padding:18px 32px 30px;">
                        <p style="margin:0; font-size:12px; line-height:1.6; color:#6b6262;">
                            Button not working? Paste this link into your browser:<br>
                            <a href="{{ $confirmUrl }}" style="color:#800000; word-break:break-all;">{{ $confirmUrl }}</a>
                        </p>
                    </td>
                </tr>

                {{-- Footer --}}
                <tr>
                    <td bgcolor="#5c0000" style="background-color:#5c0000; padding:22px 32px; font-size:13px; line-height:1.7; color:#f1e3e3;">
                        Thank you for choosing {{ $registration->event }}.<br>
                        Questions? Email <a href="mailto:{{ $contactEmail }}" style="color:#ffffff;">{{ $contactEmail }}</a>
                    </td>
                </tr>

            </table>
        </td>
    </tr>
</table>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="color-scheme" content="light">
    <title>Your {{ $registration->event }} booking</title>
</head>
<body style="margin:0; padding:0; background-color:#f1edf6; font-family:'Helvetica Neue', Helvetica, Arial, sans-serif; color:#20162f;">
@php
    $serif = "font-family:Georgia, 'Times New Roman', serif;";
    $label = 'padding:5px 16px 5px 0; font-size:13px; color:#6e6480; white-space:nowrap; vertical-align:top;';
    $value = 'padding:5px 0; font-size:14px; color:#20162f;';
@endphp
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#f1edf6;">
    <tr>
        <td align="center" style="padding:32px 14px;">
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="max-width:560px;">

                {{-- Dusk header --}}
                <tr>
                    <td bgcolor="#5a2263" style="border-radius:16px 16px 0 0; padding:34px 32px 30px; background-color:#5a2263; background-image:linear-gradient(180deg, #2a1747 0%, #8e2f6b 70%, #f08a5d 100%);">
                        <div style="{{ $serif }} font-size:30px; line-height:1.1; font-weight:bold; color:#ffffff;">{{ $registration->event }}</div>
                        <div style="padding-top:10px; font-size:14px; line-height:1.5; color:#fbe3ef;">
                            {{ $eventDate }}<br>{{ $eventVenue }}
                        </div>
                    </td>
                </tr>

                {{-- Body --}}
                <tr>
                    <td bgcolor="#ffffff" style="background-color:#ffffff; padding:30px 32px 8px;">
                        <p style="margin:0 0 12px; font-size:17px;">Hello {{ $registration->full_name }}!</p>
                        <p style="margin:0; font-size:15px; line-height:1.6; color:#4a4058;">
                            Congratulations! You have successfully registered for tickets to
                            <strong style="color:#20162f;">{{ $registration->event }}</strong>.
                            Here are your registration details.
                        </p>
                    </td>
                </tr>

                {{-- Ticket --}}
                <tr>
                    <td bgcolor="#ffffff" style="background-color:#ffffff; padding:22px 32px;">
                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0"
                               style="border:1.5px solid #f3c6a8; border-radius:12px; background-color:#fff8f2;">
                            <tr>
                                <td style="padding:18px 20px 14px;">
                                    <div style="font-size:12px; color:#6e6480;">Booking code</div>
                                    <div style="{{ $serif }} font-size:26px; font-weight:bold; letter-spacing:2px; color:#a3345b;">{{ $registration->booking_code }}</div>
                                </td>
                                <td align="right" style="padding:18px 20px 14px; vertical-align:top;">
                                    <div style="font-size:12px; color:#6e6480;">Total</div>
                                    <div style="{{ $serif }} font-size:20px; font-weight:bold; color:#20162f;">{{ \App\Models\Registration::rupiah($registration->total_price) }}</div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="padding:0 20px;">
                                    <div style="border-top:2px dashed #f3c6a8; height:0; line-height:0; font-size:0;">&nbsp;</div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="padding:12px 20px 16px;">
                                    <table role="presentation" cellpadding="0" cellspacing="0" border="0">
                                        <tr><td style="{{ $label }}">Ticket</td><td style="{{ $value }}">{{ $registration->quantity }} × {{ $registration->ticketLabel() }} ({{ \App\Models\Registration::rupiah($registration->unitPrice()) }} each)</td></tr>
                                        <tr><td style="{{ $label }}">Full name</td><td style="{{ $value }}">{{ $registration->full_name }}</td></tr>
                                        <tr><td style="{{ $label }}">Email</td><td style="{{ $value }}"><a href="mailto:{{ $registration->email }}" style="color:#a3345b;">{{ $registration->email }}</a></td></tr>
                                        <tr><td style="{{ $label }}">Birthdate</td><td style="{{ $value }}">{{ $registration->birthdate->format('F j, Y') }}</td></tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                {{-- Call to action --}}
                <tr>
                    <td bgcolor="#ffffff" align="center" style="background-color:#ffffff; padding:6px 32px 8px;">
                        <p style="margin:0 0 16px; font-size:15px; line-height:1.6; color:#4a4058; text-align:left;">
                            To complete your registration and secure your tickets, press the button below.
                        </p>
                        <table role="presentation" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td align="center" bgcolor="#c2416e" style="border-radius:12px;">
                                    <a href="{{ $confirmUrl }}" target="_blank"
                                       style="display:inline-block; padding:15px 34px; font-size:16px; font-weight:bold; color:#ffffff; text-decoration:none; border-radius:12px; background-color:#c2416e;">
                                        Confirm My Registration
                                    </a>
                                </td>
                            </tr>
                        </table>
                        <p style="margin:16px 0 0; font-size:14px; line-height:1.6; color:#4a4058;">
                            <strong style="color:#20162f;">Important:</strong> please confirm within {{ $days }} days, or the tickets are released.
                        </p>
                    </td>
                </tr>

                <tr>
                    <td bgcolor="#ffffff" style="background-color:#ffffff; padding:22px 32px 28px; border-radius:0 0 16px 16px;">
                        <p style="margin:0; font-size:12px; line-height:1.6; color:#8a8197;">
                            Button not working? Paste this link into your browser:<br>
                            <a href="{{ $confirmUrl }}" style="color:#a3345b; word-break:break-all;">{{ $confirmUrl }}</a>
                        </p>
                    </td>
                </tr>

                {{-- Footer --}}
                <tr>
                    <td align="center" style="padding:22px 20px 0; font-size:12px; line-height:1.7; color:#8a8197;">
                        Thank you for choosing {{ $registration->event }}.<br>
                        Questions? Email <a href="mailto:{{ $contactEmail }}" style="color:#a3345b;">{{ $contactEmail }}</a>
                    </td>
                </tr>

            </table>
        </td>
    </tr>
</table>
</body>
</html>

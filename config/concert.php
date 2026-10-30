<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Event details (shown on the form and in the confirmation email)
    |--------------------------------------------------------------------------
    */

    'name' => env('CONCERT_NAME', 'Nada Senja Live 2026'),

    'tagline' => env('CONCERT_TAGLINE', 'An evening of acoustic sets as the sun goes down over the city.'),

    'date' => env('CONCERT_DATE', 'Saturday, December 12, 2026, 19:00 WIB'),

    'venue' => env('CONCERT_VENUE', 'Surabaya, Indonesia'),

    /*
    |--------------------------------------------------------------------------
    | Ticket categories (key => label + price in Rupiah)
    |--------------------------------------------------------------------------
    */

    'tickets' => [
        'festival' => ['label' => 'Festival', 'price' => 350000, 'perk' => 'Standing, close to the stage'],
        'tribune' => ['label' => 'Tribune', 'price' => 500000, 'perk' => 'Numbered seat, raised view'],
        'vip' => ['label' => 'VIP', 'price' => 1250000, 'perk' => 'Front row and meet the band'],
    ],

    'max_quantity' => 4,

    /*
    |--------------------------------------------------------------------------
    | Booking code prefix, e.g. NSL-7KD2QX
    |--------------------------------------------------------------------------
    */

    'code_prefix' => env('CONCERT_CODE_PREFIX', 'NSL'),

    /*
    |--------------------------------------------------------------------------
    | How long (in days) the confirmation link in the email stays valid
    |--------------------------------------------------------------------------
    */

    'confirm_days' => (int) env('CONCERT_CONFIRM_DAYS', 7),

    /*
    |--------------------------------------------------------------------------
    | Contact address shown in the email footer
    |--------------------------------------------------------------------------
    */

    'contact_email' => env('CONCERT_CONTACT_EMAIL', env('MAIL_FROM_ADDRESS', 'hello@example.com')),

    /*
    |--------------------------------------------------------------------------
    | Optional: send a hidden copy (BCC) of every confirmation to this address
    |--------------------------------------------------------------------------
    | Leave empty to send only to the email typed in the form.
    */

    'bcc_email' => env('CONCERT_BCC_EMAIL'),

];

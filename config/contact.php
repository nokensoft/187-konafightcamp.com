<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Admin WhatsApp
    |--------------------------------------------------------------------------
    |
    | International format without "+" or spaces (e.g. 6281234567890). Used for
    | the "forgot password? contact admin" CTA and the member portal help card.
    | Set ADMIN_WHATSAPP in your .env to override the placeholder default.
    |
    */

    'whatsapp' => env('ADMIN_WHATSAPP', '6281234567890'),

    /*
    |--------------------------------------------------------------------------
    | Bank transfer (simulation)
    |--------------------------------------------------------------------------
    |
    | Simulated bank account shown to members/staff when paying for a package.
    | These are placeholders for the prototype — override them in your .env.
    |
    */

    'bank' => [
        'name' => env('BANK_NAME', 'Bank Mandiri'),
        'account_number' => env('BANK_ACCOUNT_NUMBER', '1370-0012-3456-7'),
        'account_holder' => env('BANK_ACCOUNT_HOLDER', 'PT Kona Fight Camp'),
        'branch' => env('BANK_BRANCH', 'KCP Denpasar Renon'),
    ],

];

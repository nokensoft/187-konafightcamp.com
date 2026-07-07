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

];

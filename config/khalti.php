<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Khalti Payment Gateway
    |--------------------------------------------------------------------------
    |
    | For testing use: https://a.khalti.com/api/v2/
    | For production : https://khalti.com/api/v2/
    |
    | Test secret key starts with: test_secret_key_...
    | Live secret key starts with: live_secret_key_...
    |
    */

    'secret_key' => env('KHALTI_SECRET_KEY', ''),
    'base_url'   => env('KHALTI_BASE_URL', 'https://a.khalti.com/api/v2'),
    'return_url'  => env('KHALTI_RETURN_URL', '/payment/khalti/callback'),
];

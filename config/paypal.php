<?php

return [

  'sandbox' => [
    'client_id' => env('PAYPAL_SANDBOX_CLIENT_ID'),
    'secret' => env('PAYPAL_SANDBOX_SECRET'),
  ],

  'live' => [
    'client_id' => env('PAYPAL_LIVE_CLIENT_ID'),
    'secret' => env('PAYPAL_LIVE_SECRET'),
  ],
];

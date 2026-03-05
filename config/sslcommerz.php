<?php

// SSLCommerz configuration

$apiDomain = env('SSLCZ_TESTMODE') ? "https://sandbox.sslcommerz.com" : "https://securepay.sslcommerz.com";

return [
    'apiCredentials' => [
        'store_id' => env("SSLCZ_STORE_ID"),
        'store_password' => env("SSLCZ_STORE_PASSWORD"),
    ],
    'apiUrl' => [
        'make_payment' => "/gwprocess/v4/api.php",
        'transaction_status' => "/validator/api/merchantTransIDvalidationAPI.php",
        'order_validate' => "/validator/api/validationserverAPI.php",
        'refund_payment' => "/validator/api/merchantTransIDvalidationAPI.php",
        'refund_status' => "/validator/api/merchantTransIDvalidationAPI.php",
    ],
    'apiDomain' => $apiDomain,
    'connect_from_localhost' => env("IS_LOCALHOST", true), // For Sandbox, use "true", For Live, use "false"
    
    /*
    |--------------------------------------------------------------------------
    | Callback URLs
    |--------------------------------------------------------------------------
    | These URLs must match with your routes/web.php definitions.
    | Your library file (SslCommerzNotification.php) already adds APP_URL, 
    | so we only need to provide the URI path here.
    */
    
    'success_url' => '/success',
    'failed_url'  => '/fail',
    'cancel_url'  => '/cancel',
    'ipn_url'     => '/ipn',
    
    // Fallback URLs for additional security (optional but kept for your reference)
    'fallback_success_url'  => '/payment/success',
    'fallback_redirect_url' => '/payment/redirect',
];
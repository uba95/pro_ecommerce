<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect' => env('GOOGLE_REDIRECT'),
    ],

    'facebook' => [
        'client_id' => env( 'FB_CLIENT_ID' ),
        'client_secret' => env( 'FB_CLIENT_SECRET' ),
        'redirect' => env( 'FB_REDIRECT' ),
    ],

    'stripe' => [
        'client_id' => env( 'STRIPE_KEY'),
        'client_secret' => env( 'STRIPE_SECRET' ),
        'redirect' => env( 'STRIPE_REDIRECT_URL' ),
        'cancel_url' => env( 'STRIPE_CANCEL_URL' ),
        'failed_url' => env( 'STRIPE_FAILED_URL' ),
    ],

    'paypal' => [
        'client_id' => env( 'PP_CLIENT_ID'),
        'client_secret' => env( 'PP_CLIENT_SECRET' ),
        'account_id' => env( 'PP_ACCOUNT_ID' ),
        'api_url' => env( 'PP_API_URL' ),
        'redirect' => env( 'PP_REDIRECT_URL' ),
        'cancel_url' => env( 'PP_CANCEL_URL' ),
        'failed_url' => env( 'PP_FAILED_URL' ),
        'mode' => env( 'PP_MODE' ),
    ],

];

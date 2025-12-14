<?php

return [

    /*
    |--------------------------------------------------------------------------
    | SMS Gateway Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains the configuration for SMS gateway services.
    | You can configure multiple gateways and switch between them.
    |
    */

    /*
    |--------------------------------------------------------------------------
    | Default SMS Gateway
    |--------------------------------------------------------------------------
    |
    | This option controls the default SMS gateway that will be used.
    | Supported: "0098sms", "kavenegar", "twilio"
    |
    */

    'gateway' => env('SMS_GATEWAY', '0098sms'),

    /*
    |--------------------------------------------------------------------------
    | 0098sms Gateway Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for the 0098sms gateway service.
    |
    */

    '0098sms' => [
        'username' => env('SMS_0098SMS_USERNAME'),
        'password' => env('SMS_0098SMS_PASSWORD'),
        'domain' => env('SMS_0098SMS_DOMAIN'),
        'from' => env('SMS_0098SMS_FROM'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Kavenegar Gateway Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for the Kavenegar gateway service.
    | (To be implemented)
    |
    */

    'kavenegar' => [
        'api_key' => env('SMS_KAVENEGAR_API_KEY'),
        'sender' => env('SMS_KAVENEGAR_SENDER'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Twilio Gateway Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for the Twilio gateway service.
    | (To be implemented)
    |
    */

    'twilio' => [
        'account_sid' => env('SMS_TWILIO_ACCOUNT_SID'),
        'auth_token' => env('SMS_TWILIO_AUTH_TOKEN'),
        'from' => env('SMS_TWILIO_FROM'),
    ],

];


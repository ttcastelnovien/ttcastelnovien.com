<?php

return [

    'default' => env('MAIL_MAILER', 'log'),

    'mailers' => [

        'log' => [
            'transport' => 'log',
            'channel' => env('MAIL_LOG_CHANNEL'),
        ],

    ],

    'from' => [
        'address' => env('MAIL_FROM_ADDRESS'),
        'name' => env('MAIL_FROM_NAME'),
    ],

    'reply_to' => [
        'address' => env('MAIL_REPLY_TO_ADDRESS'),
        'name' => env('MAIL_REPLY_TO_NAME'),
    ],

    'brevo_key' => env('BREVO_API_KEY'),
    'brevo_webhook_token' => env('BREVO_WEBHOOK_TOKEN'),

];

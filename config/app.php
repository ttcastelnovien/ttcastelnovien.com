<?php

return [

    'name' => env('APP_NAME', 'Laravel'),

    'env' => env('APP_ENV', 'production'),

    'debug' => (bool) env('APP_DEBUG', false),

    'url' => env('APP_URL', 'http://localhost'),

    'timezone' => 'UTC',

    'locale' => env('APP_LOCALE', 'en'),

    'fallback_locale' => env('APP_FALLBACK_LOCALE', 'en'),

    'faker_locale' => env('APP_FAKER_LOCALE', 'en_US'),

    'cipher' => 'AES-256-CBC',

    'key' => env('APP_KEY'),

    'previous_keys' => [
        ...array_filter(
            explode(',', env('APP_PREVIOUS_KEYS', ''))
        ),
    ],

    'maintenance' => [
        'driver' => env('APP_MAINTENANCE_DRIVER', 'file'),
        'store' => env('APP_MAINTENANCE_STORE', 'database'),
    ],

    'gotenberg_url' => env('GOTENBERG_URL'),

    'google' => [
        'impersonated_user' => env('GOOGLE_USER_IMPERSONATED'),
        'shared_drive_id' => env('GOOGLE_SHARED_DRIVE_ID'),
    ],

    'superuser' => [
        'firstname' => env('SUPERUSER_FIRSTNAME'),
        'lastname' => env('SUPERUSER_LASTNAME'),
        'licence' => env('SUPERUSER_LICENCE'),
        'birth_date' => env('SUPERUSER_BIRTHDATE'),
        'address' => env('SUPERUSER_ADDRESS'),
        'zip_code' => env('SUPERUSER_ZIPCODE'),
        'city' => env('SUPERUSER_CITY'),
        'username' => env('SUPERUSER_USERNAME'),
        'password' => env('SUPERUSER_PASSWORD'),
    ],

];

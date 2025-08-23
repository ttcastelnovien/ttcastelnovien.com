<?php

declare(strict_types=1);

namespace App\Services\Google;

use Google\Client;
use Google\Service\Drive;

trait GoogleSDK
{
    protected static ?Client $client = null;

    protected static function client(): Client
    {
        /*
        |--------------------------------------------------------------------------
        | Initialize Google client
        |--------------------------------------------------------------------------
        */
        if (self::$client instanceof Client) {
            return self::$client;
        }

        $credentialsPath = base_path('secrets/google_credentials.json');

        $client = new Client;
        $client->setAuthConfig($credentialsPath);
        $client->setScopes([Drive::DRIVE]);
        $client->setSubject((string) config('app.google.impersonated_user'));

        self::$client = $client;

        return self::$client;
    }
}

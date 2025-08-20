<?php

return [

    'default' => env('FILESYSTEM_DISK', 'local'),

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app/private/files'),
            'url' => env('APP_URL').'/storage/files',
            'serve' => true,
            'throw' => false,
            'report' => false,
        ],

        'clubs' => [
            'driver' => 'local',
            'root' => storage_path('app/private/clubs'),
            'url' => env('APP_URL').'/storage/clubs',
            'serve' => true,
            'throw' => false,
            'report' => false,
        ],

        'pdfs' => [
            'driver' => 'local',
            'root' => storage_path('app/private/pdfs'),
            'url' => env('APP_URL').'/storage/pdfs',
            'serve' => true,
            'throw' => false,
            'report' => false,
        ],

        'certificates' => [
            'driver' => 'local',
            'root' => storage_path('app/private/certificates'),
            'url' => env('APP_URL').'/storage/certificates',
            'serve' => true,
            'throw' => false,
            'report' => false,
        ],

    ],

];

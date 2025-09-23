<?php

use Illuminate\Support\Str;

return [
    // ... other settings ...

    'default' => env('DB_CONNECTION', 'mysql'),

    'connections' => [

        'mysql' => [
            'driver' => 'mysql',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],
        'mysql_application' => [
            'driver' => 'mysql',
            'host' => env('DB_APPLICATION_HOST', '127.0.0.1'),
            'port' => env('DB_APPLICATION_PORT', '3306'),
            'database' => env('DB_APPLICATION_DATABASE', 'application'),
            'username' => env('DB_APPLICATION_USERNAME', 'root'),
            'password' => env('DB_APPLICATION_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

          'mysql_ocr' => [
                'driver' => 'mysql',
                'host' => env('DB_OCR_HOST', '127.0.0.1'),
                'port' => env('DB_OCR_PORT', '3306'),
                'database' => env('DB_OCR_DATABASE', 'ocr_rnd'),
                'username' => env('DB_OCR_USERNAME', 'root'),
                'password' => env('DB_OCR_PASSWORD', ''),
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_ci',
                'prefix' => '',
                'strict' => true,
                'engine' => null,
            ],

        // ... other connections like sqlite, pgsql, etc. ...
    ],

    // ... other settings ...
];

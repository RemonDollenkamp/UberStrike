<?php
return [

    'bing' => [
        'base_uri' => 'https://dev.virtualearth.net/REST/v1/Routes/',
        'verify' => env('HTTP_CLIENT_VERIFY', true),
        'cert' => [env('HTTP_CLIENT_CERT', '')],
        'ssl_key' => [env('HTTP_CLIENT_SSL_KEY', '')],
        'cainfo' => env('HTTP_CLIENT_CAINFO', storage_path('cacert.pem')),
    ],

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

];

    

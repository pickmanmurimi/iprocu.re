<?php
return [
    'login_url' => env('OAUTH_URL'),

    // providers with their client id and secret
    // this is useful if we needed to implement multi auth
    'users' => [
        'client_id' => env('CLIENT_ID'),
        'client_secret' => env('CLIENT_SECRET'),
    ],
];

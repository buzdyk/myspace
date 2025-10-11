<?php

return [
    'steam' => [
        'account_id' => env('STEAM_ACCOUNT_ID')
    ],

    'mayven_1' => [
        'enabled' => true,
        'api_url' => env('MAYVEN_API_URL'),
        'token' => env('MAYVEN_AUTH'),
    ],

    'mayven_2' => [
        'enabled' => true,
        'api_url' => env('MAYVEN_API_URL_2'),
        'token' => env('MAYVEN_AUTH_2'),
    ],

    'everhour' => [
        'api_url' => env('EVERHOUR_API_URL'),
        'token' => env('EVERHOUR_TOKEN'),
    ],

    'clockify' => [
        'token' => env('CLOCKIFY_TOKEN'),
        'workspace_id' => env('CLOCKIFY_WORKSPACE_ID'),
        'user_id' => env('CLOCKIFY_USER_ID'),
    ],
];

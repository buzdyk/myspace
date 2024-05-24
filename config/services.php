<?php

return [
    'steam' => [
        'account_id' => env('STEAM_ACCOUNT_ID')
    ],

    'mayven' => [
        'api_url' => env('MAYVEN_API_URL'),
        'auth' => env('MAYVEN_AUTH'),
    ],

    'everhour' => [
        'api_url' => env('EVERHOUR_API_URL'),
        'token' => env('EVERHOUR_TOKEN'),
    ],

    'clockify' => [
        'token' => env('CLOCKIFY_TOKEN'),
        'workspace_id' => env('CLOCKIFY_WORKSPACE_ID'),
    ],
];

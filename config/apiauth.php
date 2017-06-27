<?php

return [
    'services' => [
        
        'service-1' => [
            'token' => env('SERVICE_1'),
            'tokenName' => 'api_token',

            'allowJsonToken' => true,
            'allowBearerToken' => true,
            'allowRequestToken' => true,
        ]
    ],
];

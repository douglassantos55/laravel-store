<?php

return [
    'origin' => env('SHIPPING_ORIGIN'),
    'melhor_envio' => [
        'env' => env('SHIPPING_ENV', null),
        'token' => env('SHIPPING_TOKEN'),
    ],
];

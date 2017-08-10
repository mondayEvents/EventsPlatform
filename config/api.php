<?php
return [
    'ApiRequest' => [
        'debug' => true,
        'responseFormat' => [
            'statusKey' => 'status',
            'statusOkText' => 'success',
            'statusNokText' => 'fail',
            'resultKey' => 'results',
            'messageKey' => 'message',
            'defaultMessageText' => 'Empty response!',
            'errorKey' => 'errors',
            'defaultErrorText' => 'Unknown request!'
        ],
        'log' => false,
        'jwtAuth' => [
            'enabled' => false,
        ],
        'cors' => [
            'enabled' => false,
            // 'origin' => '*',
            // 'allowedMethods' => ['GET', 'POST', 'OPTIONS'],
            // 'allowedHeaders' => ['Content-Type, Authorization, Accept, Origin'],
            // 'maxAge' => 2628000
        ]
    ]
];
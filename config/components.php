<?php

use app\components\ApiExceptionHandler;

return [
    'components' => [
        'errorHandler' => [
            'class' => ApiExceptionHandler::class,
        ],
    ],
];

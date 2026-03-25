<?php

use yii\symfonymailer\Mailer;
use yii\web\JsonResponseFormatter;
use yii\web\Response;

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

/**
 * Подключение конфигурации Dependency Injection
 */
require __DIR__ . '/di.php';

$config = [

    'id' => 'basic',
    'basePath' => dirname(__DIR__),

    'bootstrap' => ['log'],

    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],

    'components' => [

        /**
         * HTTP Request
         */
        'request' => [
            'cookieValidationKey' => 'it-link',

            // поддержка JSON API
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
        ],

        'response' => [
            'formatters' => [
                Response::FORMAT_JSON => [
                    'class' => JsonResponseFormatter::class,
                    'prettyPrint' => true,
                    'encodeOptions' => JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE,
                ],
            ],
        ],

        /**
         * Cache
         */
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],

        /**
         * User component
         */
        'user' => [
            'identityClass' => app\models\activeRecord\ApiUserAR::class,
            'enableAutoLogin' => false,
            'enableSession' => false,
        ],

        /**
         * Error handler
         */
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        /**
         * Mailer
         */
        'mailer' => [
            'class' => Mailer::class,
            'viewPath' => '@app/mail',
            'useFileTransport' => true,
        ],

        /**
         * Logging
         */
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],

        /**
         * Database
         */
        'db' => $db,

        /**
         * API routes
         */
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,

            'rules' => [
                'POST api/v1/auth/login' => 'api/v1/auth/login',

                'GET api/v1/car/list' => 'api/v1/car/list',
                'GET api/v1/car/<id:\d+>' => 'api/v1/car/view',
                'POST api/v1/car/create' => 'api/v1/car/create',
            ],
        ],

    ],

    'params' => $params,
];

if (YII_ENV_DEV) {

    // configuration adjustments for 'dev' environment

    $config['bootstrap'][] = 'debug';

    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';

    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;

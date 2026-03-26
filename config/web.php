<?php

use yii\symfonymailer\Mailer;
use yii\web\JsonResponseFormatter;
use yii\web\Response;

$params = require_once __DIR__ . '/params.php';
$db = require_once __DIR__ . '/db.php';

/**
 * Подключение конфигурации Dependency Injection
 */
require_once __DIR__ . '/di.php';

$config = [

    'id' => 'basic',

    'basePath' => dirname(__DIR__),

    'bootstrap' => ['log'],

    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],

    'modules' => [
        'api' => [
            'class' => app\modules\api\Module::class,
        ],
    ],

    'components' => [

        /**
         * HTTP Request
         */
        'request' => [
            'cookieValidationKey' => 'it-link',

            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
        ],

        /**
         * Response
         */
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
            'identityClass' => app\modules\api\v1\models\activeRecord\ApiUserAR::class,
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
                'POST api/auth/login' => 'api/auth/login',

                'GET api/car/list' => 'api/car/list',
                'GET api/car/<id:\d+>' => 'api/car/view',
                'POST api/car/create' => 'api/car/create',
            ],
        ],

    ],

    'params' => $params,
];

if (YII_ENV_DEV) {

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

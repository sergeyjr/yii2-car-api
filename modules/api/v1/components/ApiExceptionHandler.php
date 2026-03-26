<?php

namespace app\modules\api\v1\components;

use Yii;
use yii\web\ErrorHandler;
use yii\web\HttpException;
use yii\web\Response;

class ApiExceptionHandler extends ErrorHandler
{

    protected function renderException($exception): void
    {

        Yii::$app->response->format = Response::FORMAT_JSON;

        $code = 500;

        $messageDefault = 'Internal Server Error';

        if ($exception instanceof HttpException) {
            $code = $exception->statusCode;
            $message = $exception->getMessage();
        } else {
            $message = YII_DEBUG ? $exception->getMessage() : $messageDefault;
        }

        Yii::$app->response->statusCode = $code;

        Yii::$app->response->data = [
            'success' => false,
            'data' => null,
            'errors' => $message,
        ];

        Yii::$app->response->send();

    }

}

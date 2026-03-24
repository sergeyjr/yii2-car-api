<?php

namespace app\components;

use Yii;
use yii\web\ErrorHandler;
use yii\web\HttpException;
use Throwable;
use yii\web\Response;

class ApiExceptionHandler extends ErrorHandler
{
    protected function renderException($exception)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $code = 500;
        $message = 'Internal Server Error';

        if ($exception instanceof HttpException) {
            $code = $exception->statusCode;
            $message = $exception->getMessage();
        } else {
            $message = YII_DEBUG ? $exception->getMessage() : 'Internal Server Error';
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
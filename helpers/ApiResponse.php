<?php

namespace app\helpers;

use Yii;

class ApiResponse
{

    public static function success(mixed $data = null): array
    {
        return [
            'success' => true,
            'data' => $data,
            'errors' => null,
        ];
    }

    public static function error(mixed $errors, int $code = 400): array
    {
        Yii::$app->response->statusCode = $code;

        return [
            'success' => false,
            'data' => null,
            'errors' => $errors,
        ];
    }

}

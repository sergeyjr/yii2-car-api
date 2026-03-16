<?php

namespace app\helpers;

class ApiResponse
{

    public static function success($data = null): array
    {
        return [
            'success' => true,
            'data' => $data,
            'errors' => null
        ];
    }

    public static function error($errors, int $code = 400): array
    {
        \Yii::$app->response->statusCode = $code;

        return [
            'success' => false,
            'data' => null,
            'errors' => $errors
        ];
    }

}

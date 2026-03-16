<?php

namespace app\controllers\api;

use app\helpers\ApiResponse;
use yii\rest\Controller;

class BaseApiController extends Controller
{

    protected function success($data = null)
    {
        return ApiResponse::success($data);
    }

    protected function error($errors, $code = 400)
    {
        return ApiResponse::error($errors, $code);
    }

}
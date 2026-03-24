<?php

namespace app\controllers\api;

use Yii;
use yii\rest\Controller;
use yii\web\Response;
use app\helpers\ApiResponse;

class BaseApiController extends Controller
{

    public function beforeAction($action)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        return parent::beforeAction($action);
    }

    protected function success($data = null)
    {
        return ApiResponse::success($data);
    }

    protected function error($errors, $code = 400)
    {
        Yii::$app->response->statusCode = $code;

        return ApiResponse::error($errors, $code);
    }

}
<?php

namespace app\controllers\api\v1;

use Yii;
use app\services\AuthService;
use yii\web\Controller;
use yii\web\Response;

class AuthController extends Controller
{

    public $enableCsrfValidation = false;

    private AuthService $service;

    public function init()
    {
        parent::init();
        $this->service = Yii::$container->get(AuthService::class);
    }

    public function actionLogin()
    {

        Yii::$app->response->format = Response::FORMAT_JSON;

        $data = Yii::$app->request->bodyParams;

        if (empty($data['login']) || empty($data['password'])) {
            return ['error' => 'login and password required'];
        }

        $token = $this->service->login(
            $data['login'],
            $data['password']
        );

        return ['token' => $token];

    }

}

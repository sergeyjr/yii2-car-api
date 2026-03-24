<?php

namespace app\components\auth;

use Yii;
use yii\filters\auth\AuthMethod;
use yii\web\UnauthorizedHttpException;
use app\services\AuthService;

class TokenAuth extends AuthMethod
{
    public function authenticate($user, $request, $response)
    {
        $authHeader = $request->getHeaders()->get('Authorization');

        if (!$authHeader || !str_starts_with($authHeader, 'Bearer ')) {
            return null;
        }

        $token = substr($authHeader, 7);

        $authService = Yii::$container->get(AuthService::class);

        $identity = $authService->getUserByToken($token);

        if (!$identity) {
            throw new UnauthorizedHttpException('Invalid token');
        }

        return $identity;
    }
}
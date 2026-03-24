<?php

namespace app\components\auth;

use Yii;
use yii\filters\auth\AuthMethod;
use yii\web\UnauthorizedHttpException;
use app\services\AuthService;

class FlexibleAuth extends AuthMethod
{
    public function authenticate($user, $request, $response)
    {
        $params = Yii::$app->params;

        $mode = $params['authMode'] ?? 'any';

        if ($mode === 'none') {
            return true;
        }

        $apiKey = $request->getHeaders()->get('X-API-KEY');

        $authHeader = $request->getHeaders()->get('Authorization');
        $token = null;

        if ($authHeader && str_starts_with($authHeader, 'Bearer ')) {
            $token = substr($authHeader, 7);
        }

        $validApiKey = $apiKey && $apiKey === ($params['apiKey'] ?? null);

        $identity = null;

        if ($token) {
            $authService = Yii::$container->get(AuthService::class);
            $identity = $authService->getUserByToken($token);
        }

        switch ($mode) {
            case 'apikey':
                if (!$validApiKey) {
                    throw new UnauthorizedHttpException('Invalid API key');
                }
                return true;

            case 'token':
                if (!$identity) {
                    throw new UnauthorizedHttpException('Invalid token');
                }
                return $identity;

            case 'any':
                if ($validApiKey) {
                    return true;
                }

                if ($identity) {
                    return $identity;
                }

                throw new UnauthorizedHttpException('Unauthorized');
        }

        throw new UnauthorizedHttpException('Unauthorized');
    }
}
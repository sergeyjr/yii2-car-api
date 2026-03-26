<?php

namespace app\modules\api\v1\components\auth;

use Yii;
use yii\filters\auth\AuthMethod;
use yii\web\UnauthorizedHttpException;

class ApiKeyAuth extends AuthMethod
{

    public function authenticate($user, $request, $response): ?true
    {

        $apiKey = $request->getHeaders()->get('X-API-KEY');

        if (!$apiKey) {
            return null;
        }

        if ($apiKey !== Yii::$app->params['apiKey']) {
            throw new UnauthorizedHttpException('Invalid API key');
        }

        return true;

    }

}

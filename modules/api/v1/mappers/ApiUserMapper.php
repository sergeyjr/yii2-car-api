<?php

namespace app\modules\api\v1\mappers;

use app\modules\api\v1\entities\ApiUser;
use app\modules\api\v1\models\activeRecord\ApiUserAR;

class ApiUserMapper
{

    public function mapToEntity(ApiUserAR $ar): ApiUser
    {

        $user = new ApiUser($ar->login, $ar->password);

        $user->setId($ar->id);

        if ($ar->auth_token) {
            $user->setAuthToken($ar->auth_token);
        }

        return $user;

    }

    public function mapToActiveRecord(ApiUser $user, ApiUserAR $ar): ApiUserAR
    {

        $ar->login = $user->getLogin();
        $ar->password = $user->getPasswordHash();
        $ar->auth_token = $user->getAuthToken();

        return $ar;

    }

}

<?php

namespace app\mappers;

use app\entities\ApiUser;
use app\models\activeRecord\ApiUserAR;

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

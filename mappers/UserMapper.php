<?php

namespace app\mappers;

use app\entities\User;
use app\models\activeRecord\ApiUserAR;

class UserMapper
{

    public function mapToEntity(ApiUserAR $ar): User
    {

        $user = new User(
            $ar->login,
            $ar->password // из БД
        );

        $user->setId($ar->id);

        if ($ar->auth_token) {
            $user->setAuthToken($ar->auth_token);
        }

        return $user;

    }

    public function mapToActiveRecord(User $user, ApiUserAR $ar): ApiUserAR
    {

        $ar->login = $user->getLogin();
        $ar->password = $user->getPasswordHash();
        $ar->auth_token = $user->getAuthToken();

        return $ar;

    }

}
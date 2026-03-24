<?php

namespace app\mappers;

use app\entities\User;
use app\models\activeRecord\UserAR;

class UserDataMapper
{
    public function mapToEntity(UserAR $ar): User
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

    public function mapToActiveRecord(User $user, UserAR $ar): UserAR
    {
        $ar->login = $user->getLogin();
        $ar->password = $user->getPasswordHash();
        $ar->auth_token = $user->getAuthToken();

        return $ar;
    }
}
<?php

namespace app\repositories;

use app\models\activeRecord\UserAR;

class UserRepository
{

    public function findByLogin(string $login): ?UserAR
    {
        $users = UserAR::findByLogin($login);
        return $users;
    }

    public function saveToken(UserAR $user, string $token): void
    {
        $user->auth_token = $token;
        $user->save(false);
    }

}

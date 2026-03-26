<?php

namespace app\modules\api\v1\services;

use Yii;
use app\modules\api\v1\entities\ApiUser;
use app\modules\api\v1\exceptions\RepositoryException;
use app\modules\api\v1\repositories\ApiUserRepository;

class AuthService
{

    private ApiUserRepository $users;

    public function __construct(ApiUserRepository $users)
    {
        $this->users = $users;
    }

    public function login(string $login, string $password): string
    {
        $user = $this->users->findByLogin($login);

        if (!$user || !$user->validatePassword($password)) {
            throw new RepositoryException('Invalid login or password');
        }

        $token = Yii::$app->security->generateRandomString(64);

        $this->users->saveToken($user, $token);

        return $token;
    }

    public function getUserByToken(string $token): ?ApiUser
    {
        return $this->users->findByToken($token);
    }

}

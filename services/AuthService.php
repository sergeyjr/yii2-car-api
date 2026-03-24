<?php

namespace app\services;

use Yii;
use app\repositories\UserRepository;
use app\entities\User;

class AuthService
{
    private UserRepository $users;

    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    public function login(string $login, string $password): string
    {
        $user = $this->users->findByLogin($login);

        if (!$user || !$user->validatePassword($password)) {
            throw new \RuntimeException('Invalid login or password');
        }

        $token = Yii::$app->security->generateRandomString(64);

        $this->users->saveToken($user, $token);

        return $token;
    }

    public function getUserByToken(string $token): ?User
    {
        return $this->users->findByToken($token);
    }
}
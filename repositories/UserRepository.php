<?php

namespace app\repositories;

use app\entities\User;
use app\mappers\UserMapper;
use app\models\activeRecord\ApiUserAR;

class UserRepository
{

    private UserMapper $mapper;

    public function __construct(UserMapper $mapper)
    {
        $this->mapper = $mapper;
    }

    public function findByLogin(string $login): ?User
    {
        $ar = ApiUserAR::find()
            ->where(['login' => $login])
            ->one();

        if (!$ar) {
            return null;
        }

        return $this->mapper->mapToEntity($ar);
    }

    public function save(User $user): void
    {
        $ar = $user->getId()
            ? ApiUserAR::findOne($user->getId())
            : new ApiUserAR();

        $ar = $this->mapper->mapToActiveRecord($user, $ar);

        if (!$ar->save()) {
            throw new \RuntimeException('Failed to save user');
        }

        if (!$user->getId()) {
            $user->setId($ar->id);
        }
    }

    public function saveToken(User $user, string $token): void
    {
        $user->setAuthToken($token);

        $ar = ApiUserAR::findOne($user->getId());

        if (!$ar) {
            throw new \RuntimeException('User not found');
        }

        $ar->auth_token = $token;

        if (!$ar->save(false)) {
            throw new \RuntimeException('Failed to save token');
        }
    }

    public function findByToken(string $token): ?User
    {
        $ar = ApiUserAR::find()
            ->where(['auth_token' => $token])
            ->one();

        if (!$ar) {
            return null;
        }

        return $this->mapper->mapToEntity($ar);
    }

}
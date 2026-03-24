<?php

namespace app\repositories;

use app\entities\User;
use app\mappers\UserDataMapper;
use app\models\activeRecord\UserAR;

class UserRepository implements UserRepositoryInterface
{

    private UserDataMapper $mapper;

    public function __construct(UserDataMapper $mapper)
    {
        $this->mapper = $mapper;
    }

    public function findByLogin(string $login): ?User
    {
        $ar = UserAR::find()
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
            ? UserAR::findOne($user->getId())
            : new UserAR();

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

        $ar = UserAR::findOne($user->getId());

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
        $ar = UserAR::find()
            ->where(['auth_token' => $token])
            ->one();

        if (!$ar) {
            return null;
        }

        return $this->mapper->mapToEntity($ar);
    }

}
<?php

namespace app\repositories;

use app\entities\ApiUser;
use app\exceptions\UserNotFoundException;
use app\exceptions\UserSaveException;
use app\mappers\ApiUserMapper;
use app\models\activeRecord\ApiUserAR;

class ApiUserRepository
{

    private ApiUserMapper $mapper;

    public function __construct(ApiUserMapper $mapper)
    {
        $this->mapper = $mapper;
    }

    public function findByLogin(string $login): ?ApiUser
    {
        $ar = ApiUserAR::find()
            ->where(['login' => $login])
            ->one();

        return $ar ? $this->mapper->mapToEntity($ar) : null;
    }

    public function save(ApiUser $user): void
    {
        $ar = $user->getId()
            ? ApiUserAR::findOne($user->getId())
            : new ApiUserAR();

        $ar = $this->mapper->mapToActiveRecord($user, $ar);

        if (!$ar->save()) {
            throw new UserSaveException(
                'Failed to save user: ' . json_encode($ar->errors)
            );
        }

        if (!$user->getId()) {
            $user->setId($ar->id);
        }
    }

    public function saveToken(ApiUser $user, string $token): void
    {
        $user->setAuthToken($token);

        $ar = ApiUserAR::findOne($user->getId());

        if (!$ar) {
            throw new UserNotFoundException('User not found');
        }

        $ar->auth_token = $token;

        if (!$ar->save(false)) {
            throw new UserSaveException('Failed to save token');
        }
    }

    public function findByToken(string $token): ?ApiUser
    {
        $ar = ApiUserAR::find()
            ->where(['auth_token' => $token])
            ->one();

        return $ar ? $this->mapper->mapToEntity($ar) : null;
    }

}

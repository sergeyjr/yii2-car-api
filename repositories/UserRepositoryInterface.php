<?php

namespace app\repositories;

use app\entities\User;

interface UserRepositoryInterface
{
    public function findByLogin(string $login): ?User;

    public function save(User $user): void;

    public function saveToken(User $user, string $token): void;
}
<?php

namespace app\entities;

class ApiUser
{

    private ?int $id = null;

    private string $login;
    private string $passwordHash;
    private ?string $authToken = null;

    public function __construct(string $login, string $passwordHash)
    {
        $this->login = $login;
        $this->passwordHash = $passwordHash;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLogin(): string
    {
        return $this->login;
    }

    public function getPasswordHash(): string
    {
        return $this->passwordHash;
    }

    public function setAuthToken(string $token): void
    {
        $this->authToken = $token;
    }

    public function getAuthToken(): ?string
    {
        return $this->authToken;
    }

    public function validatePassword(string $password): bool
    {
        return \Yii::$app->security->validatePassword(
            $password,
            $this->passwordHash
        );
    }

}

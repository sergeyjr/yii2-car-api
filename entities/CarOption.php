<?php

namespace app\entities;

class CarOption
{

    private string $brand;
    private string $model;
    private int $year;
    private string $body;
    private int $mileage;

    public function __construct(
        string $brand,
        string $model,
        int $year,
        string $body,
        int $mileage
    ) {
        $this->brand = $brand;
        $this->model = $model;
        $this->year = $year;
        $this->body = $body;
        $this->mileage = $mileage;
    }

    public function getBrand(): string
    {
        return $this->brand;
    }

    public function getModel(): string
    {
        return $this->model;
    }

    public function getYear(): int
    {
        return $this->year;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function getMileage(): int
    {
        return $this->mileage;
    }

}


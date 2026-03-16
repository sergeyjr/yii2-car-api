<?php

namespace app\entities;

/**
 * Entity технических характеристик автомобиля.
 */
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
        int    $year,
        string $body,
        int    $mileage
    )
    {
        $this->brand = $brand;
        $this->model = $model;
        $this->year = $year;
        $this->body = $body;
        $this->mileage = $mileage;
    }

    public function fields(): array
    {
        return [
            'brand' => fn() => $this->getBrand(),
            'model' => fn() => $this->getModel(),
            'year' => fn() => $this->getYear(),
            'body' => fn() => $this->getBody(),
            'mileage' => fn() => $this->getMileage(),
        ];
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

    public function toArray(): array
    {
        return [
            'brand' => $this->getBrand(),
            'model' => $this->getModel(),
            'year' => $this->getYear(),
            'body' => $this->getBody(),
            'mileage' => $this->getMileage(),
        ];
    }

}

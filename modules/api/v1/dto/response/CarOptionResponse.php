<?php

namespace app\modules\api\v1\dto\response;

use app\modules\api\v1\entities\CarOption;

class CarOptionResponse
{

    public string $brand;
    public string $model;
    public int $year;
    public string $body;
    public int $mileage;

    public static function fromEntity(CarOption $option): self
    {
        $dto = new self();

        $dto->brand = $option->getBrand();
        $dto->model = $option->getModel();
        $dto->year = $option->getYear();
        $dto->body = $option->getBody();
        $dto->mileage = $option->getMileage();

        return $dto;
    }

}

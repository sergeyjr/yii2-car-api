<?php

namespace app\repositories;

use app\entities\CarOption;
use app\exceptions\RepositoryException;
use app\models\activeRecord\CarOptionAR;

class CarOptionRepository
{

    public function saveOption(int $carId, CarOption $option): void
    {

        $ar = new CarOptionAR();

        $ar->car_id = $carId;
        $ar->brand = $option->getBrand();
        $ar->model = $option->getModel();
        $ar->year = $option->getYear();
        $ar->body = $option->getBody();
        $ar->mileage = $option->getMileage();

        if (!$ar->save()) {
            throw new RepositoryException('Failed to save car option: ' . json_encode($ar->errors));
        }

    }

}

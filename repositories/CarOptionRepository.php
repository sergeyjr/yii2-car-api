<?php

namespace app\repositories;

use app\entities\CarOption;
use app\models\activeRecord\CarOptionAR;

/**
 * Репозиторий для работы с техническими характеристиками автомобиля.
 * Отвечает за сохранение и получение опции из базы данных.
 */
class CarOptionRepository
{

    /**
     * Сохраняет опцию автомобиля
     */
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
            throw new \RuntimeException('Failed to save car option: ' . json_encode($ar->errors));
        }

    }

    /**
     * Получает опцию автомобиля
     */
    public function findByCarId(int $carId): ?CarOption
    {
        $row = CarOptionAR::find()
            ->where(['car_id' => $carId])
            ->one();

        if (!$row) {
            return null;
        }

        return new CarOption(
            $row->brand,
            $row->model,
            $row->year,
            $row->body,
            $row->mileage
        );
    }

}
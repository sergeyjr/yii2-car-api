<?php

namespace app\repositories;

use app\entities\CarOption;

/**
 * Интерфейс репозитория технических характеристик автомобиля.
 * Определяет контракт для работы с таблицей car_option.
 */
interface CarOptionRepositoryInterface
{

    public function saveOption(int $carId, CarOption $option): void;

    public function findByCarId(int $carId): ?CarOption;

}

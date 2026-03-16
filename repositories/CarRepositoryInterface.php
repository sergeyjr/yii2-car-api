<?php

namespace app\repositories;

use app\entities\Car;
use yii\db\ActiveQuery;

/**
 * Интерфейс репозитория объявлений автомобилей.
 * Определяет контракт доступа к данным.
 */
interface CarRepositoryInterface
{

    public function save(Car $car): Car;

    public function findById(int $id): ?Car;

    public function getQuery(): ActiveQuery;

}

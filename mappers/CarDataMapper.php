<?php

namespace app\mappers;

use app\entities\Car;
use app\entities\CarOption;
use app\models\activeRecord\CarAR;

/**
 * DataMapper преобразует ActiveRecord модели в Entity и обратно.
 * Нужен чтобы бизнес-объекты не зависели от Yii ActiveRecord.
 */
class CarDataMapper
{

    /**
     * Преобразует ActiveRecord в Entity
     */
    public function mapToEntity(CarAR $ar): Car
    {

        $car = new Car(
            $ar->title,
            $ar->description,
            (float)$ar->price,
            $ar->photo_url,
            $ar->contacts,
            new \DateTime($ar->created_at)
        );

        $car->setId((int)$ar->id);

        /**
         * Добавляем одну техническую характеристику
         */
        if ($ar->option) {
            $option = $ar->option;
            $car->setOption(
                new CarOption(
                    $option->brand,
                    $option->model,
                    $option->year,
                    $option->body,
                    $option->mileage
                )
            );
        }

        return $car;

    }

    /**
     * Заполняет ActiveRecord из Entity
     */
    public function mapToActiveRecord(Car $car, CarAR $ar): CarAR
    {

        $ar->title = $car->getTitle();
        $ar->description = $car->getDescription();
        $ar->price = $car->getPrice();
        $ar->photo_url = $car->getPhotoUrl();
        $ar->contacts = $car->getContacts();

        return $ar;

    }

}
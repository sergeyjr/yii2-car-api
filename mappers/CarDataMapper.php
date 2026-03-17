<?php

namespace app\mappers;

use app\dto\response\CarListResponse;
use app\dto\response\CarResponse;
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
     * Преобразует ActiveRecord в Entity.
     *
     * Заполняет объект Car данными из модели CarAR,
     * включая связанную сущность CarOption (если она загружена).
     *
     * @param CarAR $ar ActiveRecord модель автомобиля
     * @return Car Готовая бизнес-сущность
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
     * Заполняет ActiveRecord данными из Entity.
     *
     * Используется при создании или обновлении записи в БД.
     * Не обрабатывает связанные сущности (например, CarOption),
     * их нужно сохранять отдельно.
     *
     * @param Car $car Бизнес-сущность автомобиля
     * @param CarAR $ar ActiveRecord модель для записи
     * @return CarAR Заполненная модель для сохранения
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

    /**
     * Преобразует Entity в DTO ответа одного объявления.
     *
     * Формирует объект CarResponse, который используется
     * для отдачи данных в API.
     *
     * @param Car $car Бизнес-сущность автомобиля
     * @return CarResponse DTO для ответа API
     */
    public function toResponse(Car $car): CarResponse
    {

        $dto = new CarResponse();

        $dto->id = $car->getId();
        $dto->title = $car->getTitle();
        $dto->description = $car->getDescription();
        $dto->price = $car->getPrice();
        $dto->photo_url = $car->getPhotoUrl();
        $dto->contacts = $car->getContacts();

        $option = $car->getOption();

        $dto->options = $option ? [[
            'brand' => $option->getBrand(),
            'model' => $option->getModel(),
            'year' => $option->getYear(),
            'body' => $option->getBody(),
            'mileage' => $option->getMileage(),
        ]] : null;

        return $dto;

    }

    /**
     * Преобразует набор моделей (через DataProvider) в DTO списка.
     *
     * Используется для формирования ответа списка объявлений
     * с пагинацией.
     *
     * @param \yii\data\ActiveDataProvider $provider Провайдер с моделями
     * @return CarListResponse DTO списка объявлений
     */
    public function toListResponse($provider): CarListResponse
    {
        $dto = new CarListResponse();

        $dto->page = $provider->pagination->getPage() + 1;
        $dto->total = $provider->getTotalCount();
        $dto->perPage = $provider->pagination->getPageSize();

        foreach ($provider->getModels() as $ar) {
            $car = $this->mapToEntity($ar);
            $dto->items[] = $this->toResponse($car);
        }

        return $dto;
    }

}
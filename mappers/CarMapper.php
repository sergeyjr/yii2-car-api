<?php

namespace app\mappers;

use app\dto\response\CarResponse;
use app\dto\response\CarListResponse;
use app\dto\response\CarOptionResponse;
use app\entities\Car;
use app\entities\CarOption;
use app\models\activeRecord\CarAR;

class CarMapper
{

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
                    (int)$option->year,
                    $option->body,
                    (int)$option->mileage
                )
            );
        }

        return $car;

    }

    public function mapToActiveRecord(Car $car, CarAR $ar): CarAR
    {

        $ar->title = $car->getTitle();
        $ar->description = $car->getDescription();
        $ar->price = $car->getPrice();
        $ar->photo_url = $car->getPhotoUrl();
        $ar->contacts = $car->getContacts();

        return $ar;

    }

    public function mapToResponse(Car $car): CarResponse
    {

        $dto = new CarResponse();

        $dto->id = $car->getId();
        $dto->title = $car->getTitle();
        $dto->description = $car->getDescription();
        $dto->price = $car->getPrice();
        $dto->photo_url = $car->getPhotoUrl();
        $dto->contacts = $car->getContacts();

        $option = $car->getOption();

        $dto->options = $option
            ? [CarOptionResponse::fromEntity($option)]
            : [];

        return $dto;

    }

    public function mapToListResponse($provider): CarListResponse
    {

        $dto = new CarListResponse();

        $dto->page = $provider->pagination->getPage() + 1;
        $dto->total = $provider->getTotalCount();
        $dto->perPage = $provider->pagination->getPageSize();

        foreach ($provider->getModels() as $ar) {
            $car = $this->mapToEntity($ar);
            $dto->items[] = $this->mapToResponse($car);
        }

        return $dto;

    }

}

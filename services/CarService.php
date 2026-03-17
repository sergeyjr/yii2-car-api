<?php

namespace app\services;

use app\dto\request\CreateCarRequest;
use app\dto\request\PaginationRequest;
use app\entities\Car;
use app\entities\CarOption;
use app\repositories\CarRepositoryInterface;
use yii\data\ActiveDataProvider;

class CarService
{
    private CarRepositoryInterface $repository;

    public function __construct(CarRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function createCar(CreateCarRequest $request): Car
    {
        $car = new Car(
            $request->title,
            $request->description,
            $request->price,
            $request->photo_url,
            $request->contacts,
            new \DateTime()
        );

        if ($request->options) {
            $o = $request->options;
            $car->addOption(
                new CarOption(
                    $o['brand'],
                    $o['model'],
                    $o['year'],
                    $o['body'],
                    $o['mileage']
                )
            );
        }

        return $this->repository->save($car);
    }

    public function getCar(int $id): ?Car
    {
        return $this->repository->findById($id);
    }

    /**
     * Получить список объявлений через ActiveDataProvider.
     */
    public function getCars(PaginationRequest $pagination): ActiveDataProvider
    {
        $query = $this->repository->getQuery();

        // Настраиваем ActiveDataProvider
        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'page' => $pagination->page - 1, // ActiveDataProvider начинает с 0
                'pageSize' => $pagination->pageSize,
            ],
        ]);

        // Если передана сортировка
        if ($pagination->sort) {
            // Пример: 'price' или '-price' (для сортировки по убыванию)
            $provider->sort->defaultOrder = [$pagination->sort => SORT_ASC];
        }

        return $provider;
    }

}
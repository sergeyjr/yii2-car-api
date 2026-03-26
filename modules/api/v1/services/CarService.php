<?php

namespace app\modules\api\v1\services;

use Yii;
use app\modules\api\v1\dto\request\CarCreateRequest;
use app\modules\api\v1\dto\request\CarOptionRequest;
use app\modules\api\v1\dto\request\PaginationRequest;
use app\modules\api\v1\entities\Car;
use app\modules\api\v1\repositories\CarRepository;
use yii\data\ActiveDataProvider;

class CarService
{

    private CarRepository $repository;

    private const CACHE_TTL = 600;

    public function __construct(CarRepository $repository)
    {
        $this->repository = $repository;
    }

    public function createCar(CarCreateRequest $request): Car
    {

        $car = new Car(
            $request->title,
            $request->description,
            $request->price,
            $request->photo_url,
            $request->contacts,
            new \DateTime()
        );

        $this->attachOptions($car, $request->options);

        $car = $this->repository->save($car);

        Yii::$app->cache->delete("car:{$car->getId()}");

        return $car;

    }

    public function getCar(int $id): ?Car
    {

        $cacheKey = "car:$id";

        try {
            return Yii::$app->cache->getOrSet(
                $cacheKey,
                fn() => $this->repository->findById($id),
                self::CACHE_TTL
            );
        } catch (\Throwable $e) {
            return $this->repository->findById($id);
        }

    }

    public function getCars(PaginationRequest $pagination): ActiveDataProvider
    {

        $query = $this->repository->getQuery();

        $this->applySort($query, $pagination->sort);

        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'page' => $pagination->page - 1,
                'pageSize' => $pagination->pageSize,
            ],
        ]);

    }

    private function attachOptions(Car $car, ?array $options): void
    {

        if (empty($options)) {
            return;
        }

        foreach ($options as $optionDTO) {
            $car->addOption($optionDTO->toEntity());
        }

    }

    private function applySort($query, ?string $sort): void
    {

        if (!$sort) {
            return;
        }

        $direction = str_starts_with($sort, '-') ? SORT_DESC : SORT_ASC;
        $field = ltrim($sort, '-');

        $query->orderBy([$field => $direction]);

    }

}

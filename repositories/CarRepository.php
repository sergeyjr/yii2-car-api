<?php

namespace app\repositories;

use app\entities\Car;
use app\mappers\CarDataMapper;
use app\models\activeRecord\CarAR;
use yii\db\ActiveQuery;

class CarRepository implements CarRepositoryInterface
{

    private CarDataMapper $mapper;
    private CarOptionRepository $optionRepository;

    public function __construct(
        CarDataMapper       $mapper,
        CarOptionRepository $optionRepository
    )
    {
        $this->mapper = $mapper;
        $this->optionRepository = $optionRepository;
    }

    public function save(Car $car): Car
    {

        $transaction = \Yii::$app->db->beginTransaction();

        try {
            $carAR = new CarAR();
            $this->mapper->mapToActiveRecord($car, $carAR);
            $carAR->created_at = $car->getCreatedAt()->format('Y-m-d H:i:s');

            if (!$carAR->save()) {
                throw new \RuntimeException('Failed to save car');
            }

            if ($car->getOption()) {
                $this->optionRepository->saveOption($carAR->id, $car->getOption());
            }

            $transaction->commit();

            return $this->mapper->mapToEntity($carAR);

        } catch (\Throwable $e) {
            $transaction->rollBack();
            throw $e;
        }

    }

    public function findById(int $id): ?Car
    {

        $ar = CarAR::find()
            ->with('option')
            ->where(['id' => $id])
            ->one();

        if (!$ar) {
            return null;
        }

        return $this->mapper->mapToEntity($ar);

    }

    /**
     * Возвращает ActiveQuery для пагинации через ActiveDataProvider
     */
    public function getQuery(): ActiveQuery
    {
        return CarAR::find()->with('option');
    }

}
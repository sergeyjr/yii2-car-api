<?php

namespace app\modules\api\v1\repositories;

use app\modules\api\v1\entities\Car;
use app\modules\api\v1\exceptions\RepositoryException;
use app\modules\api\v1\mappers\CarMapper;
use app\modules\api\v1\models\activeRecord\CarAR;
use yii\db\ActiveQuery;

class CarRepository
{

    private CarMapper $mapper;
    private CarOptionRepository $optionRepository;

    public function __construct(CarMapper $mapper, CarOptionRepository $optionRepository)
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
                throw new RepositoryException('Failed to save car');
            }

            if ($car->getOption()) {
                $this->optionRepository->saveOption($carAR->id, $car->getOption());
            }

            $transaction->commit();

            return $this->findById($carAR->id);

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

    public function getQuery(): ActiveQuery
    {
        return CarAR::find()->with('option');
    }

}

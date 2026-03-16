<?php

namespace app\models\activeRecord;

use yii\db\ActiveRecord;

/**
 * ActiveRecord модель таблицы car.
 */
class CarAR extends ActiveRecord
{

    public static function tableName()
    {
        return 'car';
    }

    public function getOption()
    {
        return $this->hasOne(CarOptionAR::class, ['car_id' => 'id']);
    }

    public function getOptions()
    {
        return $this->hasMany(CarOptionAR::class, ['car_id' => 'id']);
    }

}

<?php

namespace app\modules\api\v1\models\activeRecord;

use yii\db\ActiveRecord;

class CarAR extends ActiveRecord
{

    public static function tableName(): string
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

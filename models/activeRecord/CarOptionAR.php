<?php

namespace app\models\activeRecord;

use yii\db\ActiveRecord;

class CarOptionAR extends ActiveRecord
{

    public static function tableName(): string
    {
        return 'car_option';
    }

    public function rules(): array
    {
        return [
            [['car_id', 'brand', 'model', 'year', 'body', 'mileage'], 'required'],
            [['car_id', 'year', 'mileage'], 'integer'],
            [['brand', 'model', 'body'], 'string', 'max' => 255],
        ];
    }

}

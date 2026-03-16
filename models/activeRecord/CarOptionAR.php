<?php

namespace app\models\activeRecord;

use yii\db\ActiveRecord;

/**
 * ActiveRecord модель таблицы car_option.
 */
class CarOptionAR extends ActiveRecord
{

    public static function tableName()
    {
        return 'car_option';
    }

}

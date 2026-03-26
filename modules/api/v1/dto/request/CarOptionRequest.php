<?php

namespace app\modules\api\v1\dto\request;

use app\modules\api\v1\entities\CarOption;
use yii\base\Model;

class CarOptionRequest extends Model
{

    public string $brand;
    public string $model;
    public int $year;
    public string $body;
    public int $mileage;

    public function rules(): array
    {
        return [
            [['brand', 'model', 'year', 'body', 'mileage'], 'required'],
            [['brand', 'model', 'body'], 'string'],
            [['year', 'mileage'], 'integer'],

            ['year', 'integer', 'min' => 1885],
            ['mileage', 'integer', 'min' => 0],
        ];
    }

    public function toEntity(): CarOption
    {
        return new CarOption(
            $this->brand,
            $this->model,
            $this->year,
            $this->body,
            $this->mileage
        );
    }

}

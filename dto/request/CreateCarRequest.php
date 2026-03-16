<?php

namespace app\dto\request;

use yii\base\Model;

class CreateCarRequest extends Model
{

    public string $title;
    public string $description;
    public float $price;
    public string $photo_url;
    public string $contacts;
    public ?array $options = null;

    public function rules(): array
    {
        return [
            [['title', 'description', 'price', 'photo_url', 'contacts'], 'required'],
            [['title', 'description', 'photo_url', 'contacts'], 'string'],
            ['price', 'number'],
            ['options', 'safe'],
        ];
    }

}
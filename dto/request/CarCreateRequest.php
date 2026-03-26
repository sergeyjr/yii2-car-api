<?php

namespace app\dto\request;

use yii\base\Model;

class CarCreateRequest extends Model
{

    public string $title;
    public string $description;
    public float $price;
    public string $photo_url;
    public string $contacts;
    public ?array $options = null;

    public static function fromRequest(): self
    {
        $dto = new self();
        $dto->load(\Yii::$app->request->bodyParams, '');
        return $dto;
    }

    public function rules(): array
    {
        return [
            [['title', 'description', 'price', 'photo_url', 'contacts'], 'required'],
            [['title', 'description', 'photo_url', 'contacts'], 'string'],
            ['price', 'number'],

            ['options', 'validateOptions'],
        ];
    }

    public function validateOptions($attribute): void
    {
        if ($this->$attribute === null) {
            return;
        }

        if (!is_array($this->$attribute)) {
            $this->addError($attribute, 'Options must be an array');
            return;
        }

        $result = [];

        foreach ($this->$attribute as $index => $optionData) {

            if (!is_array($optionData)) {
                $this->addError($attribute, "Option #$index must be an object");
                continue;
            }

            $dto = new CarOptionRequest();
            $dto->load($optionData, '');

            if (!$dto->validate()) {
                $this->addError($attribute, [
                    'index' => $index,
                    'errors' => $dto->errors,
                ]);
                continue;
            }

            $result[] = $dto;
        }

        $this->$attribute = $result;
    }

}

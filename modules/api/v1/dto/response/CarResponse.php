<?php

namespace app\modules\api\v1\dto\response;

class CarResponse
{

    public int $id;
    public string $title;
    public string $description;
    public float $price;
    public string $photo_url;
    public string $contacts;

    public array $options = [];

}

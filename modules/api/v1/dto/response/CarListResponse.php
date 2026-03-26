<?php

namespace app\modules\api\v1\dto\response;

class CarListResponse
{

    public array $items = [];

    public int $page;
    public int $total;
    public int $perPage;

}

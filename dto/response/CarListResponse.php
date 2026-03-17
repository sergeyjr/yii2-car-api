<?php

namespace app\dto\response;

/**
 * DTO списка объявлений.
 */
class CarListResponse
{

    public array $items = [];
    public int $page;
    public int $total;
    public int $perPage;

}

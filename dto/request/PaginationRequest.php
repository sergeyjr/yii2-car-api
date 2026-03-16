<?php

namespace app\dto\request;

class PaginationRequest
{

    public int $page = 1;
    public int $pageSize = 5;
    public ?string $sort = null;

    public function __construct(array $data = [])
    {
        $this->page = (int)($data['page'] ?? $this->page);
        $this->pageSize = (int)($data['pageSize'] ?? $this->pageSize);
        $this->sort = $data['sort'] ?? $this->sort;
    }

    public static function fromQuery(): self
    {
        return new self(\Yii::$app->request->queryParams);
    }

}
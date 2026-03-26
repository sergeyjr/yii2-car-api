<?php

namespace app\dto\request;

class PaginationRequest
{

    public int $page = 1;
    public int $pageSize = 5;
    public ?string $sort = null;

    private const MAX_PAGE_SIZE = 100;

    public function __construct(array $data = [])
    {
        $this->page = max(1, (int)($data['page'] ?? $this->page));

        $this->pageSize = (int)($data['pageSize'] ?? $this->pageSize);
        $this->pageSize = max(1, min(self::MAX_PAGE_SIZE, $this->pageSize));

        $this->sort = isset($data['sort']) ? (string)$data['sort'] : null;
    }

    public static function fromQuery(): self
    {
        return new self(\Yii::$app->request->queryParams);
    }

}

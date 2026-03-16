<?php

namespace app\controllers\api\v1;

use app\controllers\api\BaseApiController;
use app\dto\request\CreateCarRequest;
use app\dto\request\PaginationRequest;
use app\helpers\ApiResponse;
use app\services\CarService;
use Yii;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\ContentNegotiator;
use yii\web\Response;

class CarController extends BaseApiController
{

    private CarService $service;

    public function __construct($id, $module, CarService $service, $config = [])
    {
        $this->service = $service;
        parent::__construct($id, $module, $config);
    }

    public function behaviors()
    {

        $behaviors = parent::behaviors();

        $behaviors['contentNegotiator'] = [
            'class' => ContentNegotiator::class,
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ],
        ];

        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
        ];

        return $behaviors;

    }

    public function actionCreate()
    {

        $request = CreateCarRequest::fromRequest();

        if (!$request->validate()) {
            return ApiResponse::error($request->errors, 422);
        }

        $car = $this->service->createCar($request);

        Yii::$app->response->statusCode = 201;

        return $this->success($car->toArray());

    }

    public function actionView($id)
    {

        $car = $this->service->getCar($id);

        if (!$car) {
            return ApiResponse::error('Car not found', 404);
            // throw new NotFoundHttpException('Car not found');
        }

        return $this->success($car->toArray());

    }

    public function actionList()
    {

        $paginationRequest = PaginationRequest::fromQuery();

        $provider = $this->service->getCars($paginationRequest);

        $items = array_map(
            fn($car) => $car->toArray(),
            $provider->getModels()
        );

        return ApiResponse::success([
            'items' => $items,
            'pagination' => [
                'totalCount' => $provider->getTotalCount(),
                'pageCount' => $provider->pagination->getPageCount(),
                'currentPage' => $provider->getPagination()->getPage() + 1,
                'perPage' => $provider->getPagination()->getPageSize(),
            ]
        ]);

    }

}
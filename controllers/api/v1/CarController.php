<?php

namespace app\controllers\api\v1;

use Yii;
use app\controllers\api\BaseApiController;
use app\dto\request\CreateCarRequest;
use app\dto\request\PaginationRequest;
use app\helpers\ApiResponse;
use app\mappers\CarDataMapper;
use app\services\CarService;
use yii\filters\ContentNegotiator;
use yii\filters\auth\HttpBearerAuth;
use yii\web\Response;

class CarController extends BaseApiController
{

    private CarService $service;
    private CarDataMapper $mapper;

    public function __construct($id, $module, CarService $service, CarDataMapper $mapper, $config = [])
    {
        $this->service = $service;
        $this->mapper = $mapper;
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

        if (Yii::$app->params['authEnabled']) {
            $behaviors['authenticator'] = [
                'class' => HttpBearerAuth::class,
            ];
        }

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

        return $this->success(
            $this->mapper->mapToResponse($car)
        );

    }

    public function actionView($id)
    {

        $car = $this->service->getCar($id);

        if (!$car) {
            return ApiResponse::error('Car not found', 404);
            // throw new NotFoundHttpException('Car not found');
        }

        return $this->success(
            $this->mapper->mapToResponse($car)
        );

    }

    public function actionList()
    {

        $paginationRequest = PaginationRequest::fromQuery();

        $provider = $this->service->getCars($paginationRequest);

        return $this->success(
            $this->mapper->mapToListResponse($provider)
        );

    }

}
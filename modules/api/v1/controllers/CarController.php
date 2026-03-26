<?php

namespace app\modules\api\v1\controllers;

use Yii;
use app\modules\api\v1\components\auth\FlexibleAuth;
use app\modules\api\v1\controllers\BaseApiController;
use app\modules\api\v1\dto\request\CarCreateRequest;
use app\modules\api\v1\dto\request\PaginationRequest;
use app\modules\api\v1\mappers\CarMapper;
use app\modules\api\v1\services\CarService;
use yii\filters\ContentNegotiator;
use yii\web\Response;

class CarController extends BaseApiController
{

    private CarService $service;
    private CarMapper $mapper;

    public function __construct($id, $module, CarService $service, CarMapper $mapper, $config = [])
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
                'class' => FlexibleAuth::class,
            ];
        }

        return $behaviors;

    }

    public function actionCreate()
    {

        $request = CarCreateRequest::fromRequest();

        if (!$request->validate()) {
            Yii::$app->response->statusCode = 422;
            return $this->error($request->errors);
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
            Yii::$app->response->statusCode = 404;
            return $this->error('Car not found');
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

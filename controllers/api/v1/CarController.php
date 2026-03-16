<?php

namespace app\controllers\api\v1;

use Yii;
use yii\rest\Controller;
use yii\web\NotFoundHttpException;
use app\services\CarService;
use app\dto\request\CreateCarRequest;
use app\dto\request\PaginationRequest;
use yii\filters\ContentNegotiator;
use yii\web\Response;
use yii\filters\auth\HttpBearerAuth;
use yii\data\ActiveDataProvider;

class CarController extends Controller
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

        $request = new CreateCarRequest();
        $request->load(Yii::$app->request->bodyParams, '');

        if (!$request->validate()) {
            Yii::$app->response->statusCode = 422;
            return $request->errors;
        }

        $car = $this->service->createCar($request);
        Yii::$app->response->statusCode = 201;

        return $car->toArray();

    }

    public function actionView($id)
    {
        $car = $this->service->getCar($id);

        if (!$car) {
            throw new NotFoundHttpException('Car not found');
        }

        return $car->toArray();
    }

    /**
     * GET /car/list?page=1&pageSize=10&sort=price
     */
    public function actionList()
    {

        // Получаем параметры запроса
        $params = Yii::$app->request->queryParams;

        // Создаем DTO пагинации
        $paginationRequest = new PaginationRequest($params);

        // Получаем ActiveDataProvider из сервиса
        $provider = $this->service->getCars($paginationRequest);

        // Получаем модели (сущности) для вывода
        $models = $provider->getModels();

        // Преобразуем сущности в массивы
        $items = array_map(
            fn($car) => $car->toArray(),
            $models
        );

        // Формируем ответ с пагинацией (как в yii\rest\ActiveController)
        return [
            'data' => $items,
            'pagination' => [
                'totalCount' => $provider->getTotalCount(),
                'pageCount' => $provider->pagination->getPageCount(),
                'currentPage' => $provider->getPagination()->getPage() + 1, // +1 т.к. ActiveDataProvider начинает с 0
                'perPage' => $provider->getPagination()->getPageSize(),
            ],
        ];

    }

}
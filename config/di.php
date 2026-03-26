<?php

use app\modules\api\v1\mappers\CarMapper;
use app\modules\api\v1\repositories\CarOptionRepository;
use app\modules\api\v1\repositories\CarRepository;
use app\modules\api\v1\repositories\ApiUserRepository;
use app\modules\api\v1\services\AuthService;
use app\modules\api\v1\services\CarService;

/**
 * Регистрация зависимостей в DI контейнере Yii.
 */

$container = Yii::$container;

$container->setSingleton(CarMapper::class);

$container->setSingleton(CarRepository::class);

$container->setSingleton(CarOptionRepository::class);

$container->setSingleton(ApiUserRepository::class);

$container->setSingleton(CarService::class);

$container->setSingleton(AuthService::class);

<?php

use app\mappers\CarMapper;
use app\repositories\CarOptionRepository;
use app\repositories\CarRepository;
use app\repositories\ApiUserRepository;
use app\services\AuthService;
use app\services\CarService;

/**
 * Регистрация зависимостей в DI контейнере Yii.
 * Здесь описывается какие реализации использовать для интерфейсов.
 */

$container = Yii::$container;

$container->setSingleton(CarMapper::class);

$container->setSingleton(CarRepository::class);

$container->setSingleton(CarOptionRepository::class);

$container->setSingleton(ApiUserRepository::class);

$container->setSingleton(CarService::class);

$container->setSingleton(AuthService::class);

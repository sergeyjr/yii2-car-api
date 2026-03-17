<?php

use app\mappers\CarDataMapper;
use app\repositories\CarOptionRepository;
use app\repositories\CarOptionRepositoryInterface;
use app\repositories\CarRepository;
use app\repositories\CarRepositoryInterface;
use app\repositories\UserRepository;
use app\repositories\UserRepositoryInterface;
use app\services\AuthService;
use app\services\CarService;

/**
 * Регистрация зависимостей в DI контейнере Yii.
 * Здесь описывается какие реализации использовать для интерфейсов.
 */

$container = Yii::$container;

$container->setSingleton(CarDataMapper::class);

$container->setSingleton(
    CarRepositoryInterface::class,
    CarRepository::class
);

$container->setSingleton(
    CarOptionRepositoryInterface::class,
    CarOptionRepository::class
);

$container->setSingleton(
    UserRepositoryInterface::class,
    UserRepository::class
);

$container->setSingleton(CarService::class);

$container->setSingleton(AuthService::class);

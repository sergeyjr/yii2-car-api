URL для тестов: http://test/api-test.html

--------------------------------------

Тестовое задание

Цель:

Создать backend API сервис объявление автомобилей

Обзор:

Разработать REST API сервис для управления объявлениями автомобилей с использованием PHP8, Yii2 и PostgreSQL.
Код должен быть организован по многослойной архитектуре с использованием паттернов
Service, Repository, Entity, DataMapper и следовать принципам SOLID.
Использовать Dependency Injection для управления зависимостями.

Требования:

1. REST API методы

POST /car/create
Создает новое объявление.
Тело запроса: {
"title": string,
"description": string,
"price": number,
"photo_url": string,
"contacts": string,
"options": [{ "brand": string, "model": string, "year": integer, "body": string, "mileage": integer }] | null
}
Ответ: 201 Created с данными объявления.

GET /car/{id}
Возвращает данные одного объявления.
Ответ: 200 OK с данными объявления и тех. хар-ми (если есть).

GET /car/list
Возвращает список всех объявлений (с пагинацией, параметр ?page).
Ответ: 200 OK с массивом объявлений.

2. База данных

Использовать PostgreSQL.
Создать таблицы:
car:
id (serial, PK),
title (varchar),
description (text),
price (decimal),
photo_url (varchar),
contacts (varchar),
created_at (timestamp).
car_option:
id (serial, PK),
car_id (integer, FK),
brand (varchar),
model (varchar),
year (integer),
body (varchar),
mileage (integer).
Связь: car_option.car_id → car.id (has-one, тех. характеристики необязательны, но если добавляются, все поля обязательны).

Использовать генерация миграция php yii migrate/create

3. Git

Создать Git-репозиторий (GitHub/GitLab).
Выполнять коммиты с понятными сообщениями (например, "setting Yii2 project", "create car module", "create REST API").
Включить README.md с инструкциями по установке и запуску.

Склонировать репозиторий: git clone <url-репозитория>.
Установить зависимости: php composer install.
Настроить PostgreSQL и выполнить php yii migrate/up.
Запустить приложение: php yii serve.

4. Опционально

Написать unit-тест для метода создания объявления в слое Service.
Завернуть в докер контейнеры

Время на выполнение: 3 полных дня.

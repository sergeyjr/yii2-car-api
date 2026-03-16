# Car API

REST API для управления объявлениями о продаже автомобилей.
Проект реализован на базе Yii2 и использует PostgreSQL в качестве базы данных.

---

# Требования

Перед установкой убедитесь, что в системе установлены:

* PHP >= 8.1
* Composer
* PostgreSQL >= 12
* Git (опционально)
* Web‑сервер (Nginx / Apache) **или** встроенный сервер PHP

---

# Получение проекта

Проект размещён на GitHub.

Есть два способа скачать код.

## Вариант 1 — скачать архив (самый простой)

1. Откройте страницу репозитория на GitHub
2. Нажмите кнопку **Code**
3. Выберите **Download ZIP**
4. Распакуйте архив

После распаковки перейдите в папку проекта.

## Вариант 2 — через git

```bash
git clone <repository-url>
cd project
```

---

# Установка зависимостей

В корневой папке проекта выполните:

```bash
composer install
```

---

# Настройка базы данных

## 1. Создать базу данных

Подключитесь к PostgreSQL и выполните:

```sql
CREATE DATABASE car_api;
```

## 2. Настроить подключение

Откройте файл:

```
config/db.php
```

Пример конфигурации для PostgreSQL:

```php
<?php

return [
    'class' => yii\\db\\Connection::class,
    'dsn' => 'pgsql:host=localhost;port=5432;dbname=car_api',
    'username' => 'postgres',
    'password' => 'password',
    'charset' => 'utf8',
];
```

---

# Миграции

После настройки базы необходимо выполнить миграции:

```bash
php yii migrate
```

Будут созданы таблицы:

* `user`
* `car`
* `car_option`

---

# Запуск проекта

## Встроенный сервер PHP

Из корневой директории проекта выполните:

```bash
php yii serve
```

По умолчанию сервер запустится на:

```
http://localhost:8080
```

---

# Аутентификация

API использует авторизацию по **Bearer Token**.

## Получение токена

Запрос:

```
POST /api/v1/auth/login
```

Body запроса:

```json
{
  "login": "admin",
  "password": "123456"
}
```

Ответ:

```json
{
  "token": "YOUR_ACCESS_TOKEN"
}
```

---

# Использование токена

Все защищённые запросы должны содержать заголовок:

```
Authorization: Bearer YOUR_ACCESS_TOKEN
```

---

# Эндпоинты API

## Создание объявления

```
POST /api/v1/car/create
```

Пример запроса:

```json
{
  "title": "BMW X5",
  "description": "Без пробега по РФ",
  "price": 5500000,
  "photo_url": "https://example.com/bmw.jpg",
  "contacts": "ivan@example.com",
  "options": {
    "brand": "BMW",
    "model": "X5",
    "year": 2022,
    "body": "SUV",
    "mileage": 0
  }
}
```

---

## Получение объявления

```
GET /api/v1/car/{id}
```

Пример:

```
GET /api/v1/car/1
```

---

## Получение списка объявлений

```
GET /api/v1/car/list
```

Поддерживаемые параметры:

| Параметр | Описание                       |
| -------- | ------------------------------ |
| page     | номер страницы                 |
| pageSize | количество записей на странице |
| sort     | поле сортировки                |

### Пример запроса

```
/api/v1/car/list?page=1&pageSize=10&sort=-created_at
```

### Поддерживаемая сортировка

```
id
-id
title
-title
price
-price
created_at
-created_at
```

---

# Структура проекта

```
config/
controllers/
controllers/api/v1/
dto/
entities/
mappers/
migrations/
models/
repositories/
services/
```

Краткое описание:

* **controllers** — HTTP контроллеры API
* **dto** — объекты передачи данных для запросов и ответов
* **entities** — бизнес‑сущности
* **repositories** — работа с базой данных
* **services** — бизнес‑логика приложения
* **migrations** — миграции базы данных

---

# Тестирование API

Для тестирования можно использовать:

* Postman
* curl
* любой HTTP‑клиент
* встроенную HTML‑страницу API‑тестера (если присутствует в проекте)

---

# Пример запроса через curl

Получение списка автомобилей:

```bash
curl -H "Authorization: Bearer TOKEN" \
http://localhost:8080/api/v1/car/list
```

---

# Лицензия

Test project.

## Общие сведения

**Base URL:**

```
http://localhost/api/v1
```

API использует единый формат ответа:

```
success / data / errors
```

Доступ к методам `/car/*` защищён middleware `auth.flex:auto`, режим берётся из `.env`:

```
AUTH_MODE=any
```

---

## Режимы авторизации

**auth.flex:none**
Доступ без авторизации. Используется для логина.

**auth.flex:apikey**
Требуется только API ключ.

**auth.flex:token**
Требуется только Bearer токен.

**auth.flex:any**
Достаточно либо API ключа, либо токена.

**auth.flex:auto**
Режим определяется через `.env` (`AUTH_MODE`).

---

## API ключ

Задаётся в `.env`:

```
API_KEY=kpR85bh5hge%$
```

Передаётся в заголовке:

```
X-API-KEY: kpR85bh5hge%$
```

Может использоваться вместо токена при режиме `any`.

---

## Получение токена

Токен отсутствует в базе по умолчанию и создаётся при логине.

**Запрос:**

```
POST /api/v1/auth/login?login=admin&password=123456
```

**Логика:**

* поиск пользователя по login
* проверка пароля
* генерация токена (строка длиной 64 символа)
* сохранение в `api_user.auth_token`

**Ответ:**

```json
{
  "success": true,
  "data": {
    "token": "..."
  }
}
```

---

## Использование токена

Передаётся в заголовке:

```
Authorization: Bearer {token}
```

При повторном логине токен перезаписывается.

---

## Создание автомобиля

**Запрос:**

```
POST /api/v1/car/create
```

Требует авторизацию (token или API key).

**Body:**

```json
{
  "title": "Audi A4",
  "description": "German sedan",
  "price": 18000,
  "photo_url": "https://example.com/audi.jpg",
  "contacts": "admin@example.com",
  "options": [
    {
      "brand": "Audi",
      "model": "A4",
      "year": 2018,
      "body": "sedan",
      "mileage": 120000
    }
  ]
}
```

**Особенности:**

* `options` — массив
* может быть пустым или отсутствовать
* поля внутри валидируются по типам БД

---

## Получение списка автомобилей

**Запрос:**

```
GET http://localhost/api/v1/car/list?page=1&pageSize=2
```

**Параметры:**

* `page` — номер страницы
* `pageSize` — количество элементов

**Ответ:**

```json
{
  "success": true,
  "data": {
    "items": [...],
    "page": 1,
    "total": 10,
    "perPage": 2
  }
}
```

---

## Получение автомобиля по ID

**Запрос:**

```
GET http://localhost/api/v1/car/1
```

**Ответ:**

```json
{
  "success": true,
  "data": {
    "id": 1,
    "title": "Audi A4",
    "description": "German sedan",
    "price": 18000,
    "photo_url": "...",
    "contacts": "...",
    "options": [
      {
        "brand": "Audi",
        "model": "A4",
        "year": 2018,
        "body": "sedan",
        "mileage": 120000
      }
    ]
  }
}
```

Если опций нет:

```json
"options": []
```

---

## Ошибки

**Без авторизации:**

```json
{
  "success": false,
  "errors": "Unauthorized"
}
```

**Неверный API ключ:**

```json
{
  "success": false,
  "errors": "Invalid API key"
}
```

**Неверный токен:**

```json
{
  "success": false,
  "errors": "Invalid token"
}
```

**Ошибка валидации:**

```json
{
  "success": false,
  "errors": {
    "field": ["error message"]
  }
}
```

**Не найдено:**

```json
{
  "success": false,
  "errors": "Car not found"
}
```

---

## Порядок работы

1. Выполнить логин и получить токен (или использовать API ключ)
2. Добавить заголовок авторизации
3. Вызывать методы `/car/*`
4. Использовать пагинацию и параметры запроса

---

## Итог

API поддерживает два способа авторизации: токен и API ключ.
Токен создаётся динамически при логине.
Доступ регулируется через настраиваемые режимы.
Структура запросов и ответов унифицирована.

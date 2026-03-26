```md
# Установка API модуля (Yii2)

## 1. Подготовка архива

Модуль поставляется в виде архива со структурой:

```

yii2_api_v1/
├── config/
│   ├── di.php
│   ├── params.php
│   └── web.php
├── migrations/
└── modules/

```

---

## 2. Копирование файлов

### 2.1 Копирование модулей и миграций

Скопировать директории:

```

yii2_api_v1/modules
yii2_api_v1/migrations

```

в корень проекта Yii2:

```

/modules
/migrations

```

---

### 2.2 Копирование конфигурации

Скопировать файлы:

```

yii2_api_v1/config/di.php
yii2_api_v1/config/params.php
yii2_api_v1/config/web.php

```

в папку:

```

/config

````

⚠️ **Важно:**  
Файлы в `/config` уже существуют, поэтому:

- **НЕ перезаписывать их напрямую**
- необходимо **аккуратно объединить содержимое**

---

## 3. Объединение конфигурации

### 3.1 `web.php`

Обязательно объединить:

#### Модули

```php
'modules' => [
    'api' => [
        'class' => app\modules\api\Module::class,
    ],
],
````

#### URL правила

```php
'urlManager' => [
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'rules' => [
        'POST api/auth/login' => 'api/auth/login',

        'GET api/car/list' => 'api/car/list',
        'GET api/car/<id:\d+>' => 'api/car/view',
        'POST api/car/create' => 'api/car/create',
    ],
],
```

#### Компонент user

```php
'user' => [
    'identityClass' => app\modules\api\v1\models\activeRecord\ApiUserAR::class,
    'enableSession' => false,
],
```

---

### 3.2 `di.php`

Подключить в `config/web.php`:

```php
require_once __DIR__ . '/di.php';
```

Если файл уже используется — объединить зависимости вручную.

---

### 3.3 `params.php`

Объединить параметры:

```php
$params = array_merge(
    require __DIR__ . '/params.php',
    // добавить параметры API
);
```

Либо перенести недостающие ключи вручную.

---

## 4. Namespace контроллеров

Файл: `modules/api/Module.php`

```php
class Module extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\api\v1\controllers';
}
```

---

## 5. Применение миграций

```bash
php yii migrate
```

или (если используется отдельный путь):

```bash
php yii migrate --migrationPath=@app/modules/api/v1/migrations
```

---

## 6. Проверка namespace

Все классы должны использовать:

```
namespace app\modules\api\v1\...
```

---

## 7. Проверка работы API

```
GET  /api/car/1
POST /api/car/create
```

---

## Итог

Минимальные шаги:

* Скопировать `modules` и `migrations` в корень проекта
* Аккуратно объединить файлы в `/config`
* Подключить модуль в `web.php`
* Настроить `urlManager`
* Подключить `di.php`
* Выполнить миграции

```
```

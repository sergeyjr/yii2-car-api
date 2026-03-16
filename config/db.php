<?php

/*
* Контейнер PHP пытается подключиться к PostgreSQL по адресу 127.0.0.1:5432
* Но внутри Docker 127.0.0.1 означает сам контейнер PHP, а не контейнер базы данных.
* Поэтому хост должен быть не localhost, а postgres
*/

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'pgsql:host=postgres;dbname=postgres',
    'username' => 'postgres',
    'password' => 'postgres',
    'charset' => 'utf8',
];

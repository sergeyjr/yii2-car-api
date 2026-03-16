<?php

use yii\db\Migration;

/**
 * Миграция создания таблицы car.
 */
class m260313_212150_create_car_table extends Migration
{

    public function safeUp()
    {
        $this->createTable('car', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'description' => $this->text(),
            'price' => $this->decimal(10, 2),
            'photo_url' => $this->string(),
            'contacts' => $this->string(),
            'created_at' => $this->timestamp(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('car');
    }

}
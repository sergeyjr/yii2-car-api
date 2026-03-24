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
            'title' => $this->string()->notNull(),
            'description' => $this->text()->notNull(),
            'price' => $this->decimal(12, 2)->notNull(),
            'photo_url' => $this->string()->notNull(),
            'contacts' => $this->string()->notNull(),
            'created_at' => $this->timestamp()->null(),
            'updated_at' => $this->timestamp()->null(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('car');
    }

}
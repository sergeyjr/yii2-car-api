<?php

use yii\db\Migration;

class m260313_212521_create_car_option_table extends Migration
{

    public function safeUp()
    {

        $this->createTable('car_option', [

            'id' => $this->primaryKey(),
            'car_id' => $this->integer()->notNull()->unique(),

            'brand' => $this->string(100)->notNull(),
            'model' => $this->string(100)->notNull(),
            'year' => $this->integer()->notNull(),
            'body' => $this->string(100)->notNull(),
            'mileage' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'fk_car_option_car',
            'car_option',
            'car_id',
            'car',
            'id',
            'CASCADE'
        );

        // CHECK ограничения
        $this->execute("
            ALTER TABLE car_option
            ADD CONSTRAINT chk_car_option_year CHECK (year >= 1885)
        ");

        $this->execute("
            ALTER TABLE car_option
            ADD CONSTRAINT chk_car_option_mileage CHECK (mileage >= 0)
        ");
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_car_option_car', 'car_option');

        $this->dropTable('car_option');
    }

}
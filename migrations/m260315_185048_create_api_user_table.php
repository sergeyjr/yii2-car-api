<?php

use yii\db\Migration;

class m260315_185048_create_api_user_table extends Migration
{

    public function safeUp()
    {

        $this->createTable('api_user', [
            'id' => $this->primaryKey(),
            'login' => $this->string(100)->notNull(),
            'password' => $this->string()->notNull(),
            'auth_token' => $this->string()->null(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->null(),
        ]);

        $this->createIndex(
            'idx_api_user_login_unique',
            'api_user',
            'login',
            true
        );

        $this->insert('api_user', [
            'login' => 'admin',
            'password' => \Yii::$app->security->generatePasswordHash('123456'),
            'created_at' => date('Y-m-d H:i:s'),
        ]);

    }

    public function safeDown()
    {

        $this->dropIndex('idx_api_user_login_unique', 'api_user');

        $this->dropTable('api_user');

    }

}

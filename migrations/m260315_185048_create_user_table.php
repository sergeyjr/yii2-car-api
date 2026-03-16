<?php

use yii\db\Migration;

class m260315_185048_create_user_table extends Migration
{

    public function safeUp()
    {

        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'login' => $this->string(100)->notNull()->unique(),
            'password_hash' => $this->string()->notNull(),
            'auth_token' => $this->string(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        // создаем admin пользователя
        $this->insert('{{%user}}', [
            'login' => 'admin',
            'password_hash' => \Yii::$app->security->generatePasswordHash('123456'),
            'created_at' => date('Y-m-d H:i:s'),
        ]);

    }

    public function safeDown()
    {
        $this->dropTable('{{%user}}');
    }

}

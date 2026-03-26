<?php

namespace app\models\activeRecord;

use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class ApiUserAR extends ActiveRecord implements IdentityInterface
{

    public static function tableName()
    {
        return 'api_user';
    }

    public static function findIdentity($id)
    {
        return self::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return self::find()
            ->where(['auth_token' => $token])
            ->one();
    }

    public static function findByLogin(string $login): ?ApiUserAR
    {
        $user = self::find()
            ->where(['login' => $login])
            ->one();

        return $user instanceof self ? $user : null;
    }

    public function validatePassword($password): bool
    {
        return \Yii::$app->security->validatePassword(
            $password,
            $this->password
        );
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->auth_token;
    }

    public function validateAuthKey($authKey): bool
    {
        return $this->auth_token === $authKey;
    }

}

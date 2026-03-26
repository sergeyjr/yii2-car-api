<?php

namespace app\modules\api;

use app\modules\api\v1\components\ApiExceptionHandler;

class Module extends \yii\base\Module
{

    public $controllerNamespace = 'app\modules\api\v1\controllers';

    public function init()
    {
        parent::init();

        \Yii::$app->set('errorHandler', [
            'class' => ApiExceptionHandler::class,
        ]);
    }

}

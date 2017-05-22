<?php

namespace app\modules\wechat\controllers;

use yii\rest\ActiveController;

/**
 * Default controller for the `wechat` module
 */
class LoginController extends ActiveController
{
    public $modelClass = 'app\models\Activity';

    public function actions()
    {
        return [
            'index' => [
                'class' => 'app\modules\wechat\actions\login\IndexAction',
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],
            ],
        ];
    }
}

<?php

namespace app\modules\wechat\controllers;

use yii\rest\ActiveController;

/**
 * Default controller for the `wechat` module
 */
class SigninController extends ActiveController
{
    public $modelClass = 'app\models\User';

    public function actions()
    {
        return [
            'create' => [
                'class' => 'app\modules\wechat\actions\signin\CreateAction',
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],
            ]
        ];
    }
}

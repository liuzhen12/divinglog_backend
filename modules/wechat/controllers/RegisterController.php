<?php

namespace app\modules\wechat\controllers;

use yii\rest\ActiveController;

/**git
 * Default controller for the `wechat` module
 */
class RegisterController extends ActiveController
{
    public $modelClass = 'app\models\User';

    public function actions()
    {
        return [
            'create' => [
                'class' => 'app\modules\wechat\actions\register\CreateAction',
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],
            ]
        ];
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: liuzhen12
 * Date: 17-5-16
 * Time: 下午4:06
 */

namespace app\controllers;


use yii\rest\ActiveController;

class UserController extends ActiveController
{
    public $modelClass = 'app\models\User';

    public function actions()
    {
        $actions = parent::actions();
        $modelClass = $this->modelClass;
        $actions['view'] = [
            'class' => 'app\components\base\BaseViewAction',
            'modelClass' => $modelClass,
            'checkAccess' => [$this, 'checkAccess'],
        ];
        return $actions;
    }
}
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

//    public function actions()
//    {
//        $actions = parent::actions();
//        $actions['view'] = [
//            'class' => 'app\actions\user\ViewAction',
//            'modelClass' => $this->modelClass,
//            'checkAccess' => [$this, 'checkAccess']
//        ];
//        return $actions;
//    }
}
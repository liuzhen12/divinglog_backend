<?php
/**
 * Created by PhpStorm.
 * User: liuzhen12
 * Date: 17-7-4
 * Time: 下午4:39
 */

namespace app\controllers;


use app\components\base\BaseController;

class DiverLevelController extends BaseController
{
    public $modelClass = 'app\models\DiverLevel';

    public function actions()
    {
        $modelClass = $this->modelClass;
        $actions = [
            'index' => [
                'class' => 'app\components\base\BaseIndexAction',
                'modelClass' => $modelClass,
                'checkAccess' => [$this, 'checkAccess'],
                'scenario' => $modelClass::SCENARIO_LEVEL,
                'identity' =>'id'
            ],
            'update' => [
                'class' => 'yii\rest\UpdateAction',
                'modelClass' => $modelClass,
                'checkAccess' => [$this, 'checkAccess'],
                'scenario' => $modelClass::SCENARIO_LEVEL,
            ],
            'view' => [
                'class' => 'yii\rest\ViewAction',
                'modelClass' => $modelClass,
                'checkAccess' => [$this, 'checkAccess']
            ]
        ];
        return $actions;
    }
}
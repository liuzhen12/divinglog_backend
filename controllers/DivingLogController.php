<?php
/**
 * Created by PhpStorm.
 * User: liuzhen12
 * Date: 17-5-16
 * Time: 下午7:45
 */

namespace app\controllers;


use app\components\base\BaseController;

class DivingLogController extends BaseController
{
    public $modelClass = 'app\models\DivingLog';

    public function actions()
    {
        $actions = parent::actions();
        $actions['create'] = [
            'class' => 'app\actions\divingLog\CreateAction',
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
            'scenario' => $this->createScenario,
        ];
        $actions['delete'] = [
            'class' => 'app\actions\divingLog\DeleteAction',
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
        ];
        return $actions;
    }
}
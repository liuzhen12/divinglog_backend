<?php
/**
 * Created by PhpStorm.
 * User: liuzhen12
 * Date: 17-5-16
 * Time: 下午7:45
 */

namespace app\controllers;


use app\components\base\BaseController;

class EquipController extends BaseController
{
    public $modelClass = 'app\models\Equip';

    public function actions()
    {
        $actions = parent::actions();
        $modelClass = $this->modelClass;
        $actions['index'] = [
            'class' => 'app\components\base\BaseIndexAction',
            'modelClass' => $modelClass,
            'checkAccess' => [$this, 'checkAccess']
        ];
        $actions['create'] = [
            'class' => 'app\actions\equip\CreateAction',
            'modelClass' => $modelClass,
            'checkAccess' => [$this, 'checkAccess'],
            'scenario' => $modelClass::SCENARIO_CREATE,
        ];
        $actions['delete'] = [
            'class' => 'app\actions\equip\DeleteAction',
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
        ];
        return $actions;
    }
}
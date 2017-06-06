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
        $actions['create'] = [
            'class' => 'app\actions\equip\CreateAction',
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
        ];
        $actions['delete'] = [
            'class' => 'app\actions\equip\DeleteAction',
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
        ];
        return $actions;
    }
}
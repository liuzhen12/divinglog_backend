<?php
/**
 * Created by PhpStorm.
 * User: liuzhen12
 * Date: 17-5-16
 * Time: 下午7:47
 */

namespace app\controllers;


use app\components\base\BaseController;

class SpecialityController extends BaseController
{
    public $modelClass = 'app\models\Speciality';

    public function actions()
    {
        $actions = parent::actions();
        $actions['create'] = [
            'class' => 'app\actions\speciality\CreateAction',
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
        ];
        $actions['delete'] = [
            'class' => 'app\actions\speciality\DeleteAction',
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
        ];
        return $actions;
    }
}
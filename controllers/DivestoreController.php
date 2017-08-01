<?php
/**
 * Created by PhpStorm.
 * User: liuzhen12
 * Date: 17-5-16
 * Time: 下午7:44
 */

namespace app\controllers;


use app\components\base\BaseController;

class DivestoreController extends BaseController
{
    public $modelClass = 'app\models\Divestore';

    public function actions()
    {
        $actions = parent::actions();
        $modelClass = $this->modelClass;
        $actions['view'] = [
            'class' => 'app\components\base\BaseViewAction',
            'modelClass' => $modelClass,
            'checkAccess' => [$this, 'checkAccess'],
//            'scenario' => $modelClass::SCENARIO_VIEW,
        ];
        return $actions;
    }
}
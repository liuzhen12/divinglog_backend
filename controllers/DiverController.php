<?php
/**
 * Created by PhpStorm.
 * User: liuzhen12
 * Date: 17-7-5
 * Time: 上午11:34
 */

namespace app\controllers;


use app\components\base\BaseController;

class DiverController extends BaseController
{
    public $modelClass = 'app\models\User1';

    public function actions()
    {
        $actions = parent::actions();
        $modelClass = $this->modelClass;
        $actions['index'] = [
            'class' => 'app\components\base\BaseIndexAction',
            'modelClass' => $modelClass,
            'checkAccess' => [$this, 'checkAccess'],
            'scenario' => $modelClass::SCENARIO_INDEX,
            'identity' => 'id'
        ];
        return $actions;
    }
}
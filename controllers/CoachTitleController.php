<?php
/**
 * Created by PhpStorm.
 * User: liuzhen12
 * Date: 17-7-3
 * Time: 下午5:34
 */

namespace app\controllers;


use app\components\base\BaseController;


class CoachTitleController extends BaseController
{
    public $modelClass = 'app\models\CoachTitle';

    public function actions()
    {
        $actions = parent::actions();
        $modelClass = $this->modelClass;
        $actions['index'] = [
            'class' => 'app\components\base\BaseIndexAction',
            'modelClass' => $modelClass,
            'checkAccess' => [$this, 'checkAccess'],
            'scenario' => $modelClass::SCENARIO_TITLE,
            'identity' =>'id'
        ];
        $actions['update'] = [
            'class' => 'yii\rest\UpdateAction',
            'modelClass' => $modelClass,
            'checkAccess' => [$this, 'checkAccess'],
            'scenario' => $modelClass::SCENARIO_TITLE,
        ];
        return $actions;
    }
}
<?php

namespace app\controllers;

use app\components\base\BaseController;

class ActivityController extends BaseController
{
    public $modelClass = 'app\models\Activity';

    public function actions()
    {
        $actions = parent::actions();
        $modelClass = $this->modelClass;
        $actions['index'] = [
            'class' => 'app\components\base\BaseIndexAction',
            'modelClass' => $modelClass,
            'checkAccess' => [$this, 'checkAccess'],
            'scenario' => $modelClass::SCENARIO_INDEX
        ];
        return $actions;
    }

}

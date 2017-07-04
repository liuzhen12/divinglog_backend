<?php
/**
 * Created by PhpStorm.
 * User: liuzhen12
 * Date: 17-5-16
 * Time: 下午7:46
 */

namespace app\controllers;


use app\components\base\BaseController;

class LevelController extends BaseController
{
    public $modelClass = 'app\models\Level';

    public function actions()
    {
        $actions = parent::actions();
        $modelClass = $this->modelClass;
        $actions['index'] = [
            'class' => 'app\components\base\BaseIndexAction',
            'modelClass' => $modelClass,
            'checkAccess' => [$this, 'checkAccess']
        ];
        $actions['create']['scenario'] = $modelClass::SCENARIO_CREATE;
        $actions['update']['scenario'] = $modelClass::SCENARIO_CERTIFICATE;

        return $actions;
    }
}
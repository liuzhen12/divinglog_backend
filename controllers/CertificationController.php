<?php
/**
 * Created by PhpStorm.
 * User: liuzhen12
 * Date: 17-5-16
 * Time: 下午7:36
 */

namespace app\controllers;


use app\components\base\BaseController;
use app\models\Certification;

class CertificationController extends BaseController
{
    public $modelClass = 'app\models\Certification';

    public function init()
    {
        parent::init();
        $this->createScenario = Certification::SCENARIO_CERTIFICATE;
        $this->updateScenario = Certification::SCENARIO_EVALUATE;
    }

    public function actions()
    {
        $actions = parent::actions();
        $actions['update'] = [
            'class' => 'app\actions\certification\UpdateAction',
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
            'scenario' => $this->updateScenario,
        ];
        return $actions;
    }
}
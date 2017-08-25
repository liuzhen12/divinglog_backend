<?php

namespace app\controllers;

use app\components\base\BaseController;
use yii\helpers\Url;

class ActivityController extends BaseController
{
    public $modelClass = 'app\models\Activity';

    public $serializer = [
        'class' => 'app\components\base\BaseSerializer',
        'collectionEnvelope' => 'items',
        'extraLinksClosure' => 'getExtraLinks',
    ];

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
        $actions['view'] = [
            'class' => 'app\components\base\BaseViewAction',
            'modelClass' => $modelClass,
            'checkAccess' => [$this, 'checkAccess'],
        ];
        return $actions;
    }

    public function getExtraLinks()
    {
        return [
            'create' => Url::to(['@web/activities'], true),
        ];
    }
}

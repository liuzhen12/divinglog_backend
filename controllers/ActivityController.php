<?php

namespace app\controllers;

use app\components\base\BaseController;
use app\models\Activity;
use Yii;
use yii\data\ActiveDataProvider;
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
            'scenario' => $modelClass::SCENARIO_INDEX,
            'prepareDataProvider' => [$this, 'prepareDataProvider']
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

    public function prepareDataProvider()
    {
        $start_date =  Yii::$app->getRequest()->get('start_date');
        $end_date = Yii::$app->getRequest()->get('end_date');
        $northeast_longitude =  Yii::$app->getRequest()->get('northeast_longitude');
        $northeast_latitude =  Yii::$app->getRequest()->get('northeast_latitude');
        $southwest_longitude =  Yii::$app->getRequest()->get('southwest_longitude');
        $southwest_latitude =  Yii::$app->getRequest()->get('southwest_latitude');
        $max_member= Yii::$app->getRequest()->get('max_member');

        $activity = Activity::tableName();
        $condition = [];
        $sort = ["{$activity}.updated_at"=>SORT_DESC];
        $query = Activity::find()
            ->select(implode(',',array_merge((new Activity(['scenario' => Activity::SCENARIO_INDEX]))->activeAttributes(),["{$activity}.id"])));
        if(!empty($start_date)){
            $query->andWhere(["=" , "{$activity}.start_date" , $start_date]);
        }
        if(!empty($end_date)){
            $query->andWhere(["=" , "{$activity}.end_date" , $end_date]);
        }
        if(!empty($northeast_longitude)){
            $query->andWhere(["<=", "{$activity}.location_longitude" ,$northeast_longitude]);
        }
        if(!empty($northeast_latitude)){
            $query->andWhere(["<=", "{$activity}.location_latitude" ,$northeast_latitude]);
        }
        if(!empty($southwest_longitude)){
            $query->andWhere([">=", "{$activity}.location_longitude" ,$southwest_longitude]);
        }
        if(!empty($southwest_latitude)){
            $query->andWhere([">=", "{$activity}.location_latitude" ,$southwest_latitude]);
        }
        if(!empty($max_member) && in_array($max_member,[1,2])){
            $sort["{$activity}.evaluation_score"] = 1 == $max_member ? SORT_ASC : SORT_DESC;
            unset($sort["{$activity}.updated_at"]);
        }
        $query->orderBy($sort);
        var_dump($query->createCommand()->getRawSql());exit;
        return Yii::createObject([
            'class' => ActiveDataProvider::className(),
            'query' => $query,
            'pagination' => [
                'pageSize' => 15,
            ],
//            'sort' => [
//                'defaultOrder' => $sort,
//            ],
        ]);
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: liuzhen12
 * Date: 17-5-16
 * Time: 下午7:44
 */

namespace app\controllers;


use app\components\base\BaseController;
use app\models\Divestore;
use app\models\Language;
use Yii;
use yii\data\ActiveDataProvider;

class DivestoreController extends BaseController
{
    public $modelClass = 'app\models\Divestore';

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
//            'scenario' => $modelClass::SCENARIO_VIEW,
        ];
        return $actions;
    }

    public function prepareDataProvider()
    {
        $no =  Yii::$app->getRequest()->get('no');
        $country =  Yii::$app->getRequest()->get('country');
        $province =  Yii::$app->getRequest()->get('province');
        $city =  Yii::$app->getRequest()->get('city');
        $gender = Yii::$app->getRequest()->get('gender');
        $language = Yii::$app->getRequest()->get('language');
        $evaluationScore = Yii::$app->getRequest()->get('evaluation_score');
        $coachCount = Yii::$app->getRequest()->get('coach_count');

        $divestore = Divestore::tableName();
        $condition = [];
        $sort = ["{$divestore}.updated_at"=>SORT_DESC];
        $query = Divestore::find()
            ->select(implode(',',array_merge((new Divestore(['scenario' => Divestore::SCENARIO_INDEX]))->activeAttributes(),["{$divestore}.id"])));

        if(!empty($no)){
            $condition["{$divestore}.no"] = $no;
        }
        if(!empty($country)){
            $condition["{$divestore}.country"] = $country;
        }
        if(!empty($province)){
            $condition["{$divestore}.province"] = $province;
        }
        if(!empty($city)){
            $condition["{$divestore}.city"] = $city;
        }
        if(!empty($gender)){
            $condition["{$divestore}.gender"] = explode(',',$gender);
        }
        if(!empty($evaluationScore) && in_array($evaluationScore,[1,2])){
            $sort["{$divestore}.evaluation_score"] = 1 == $evaluationScore ? SORT_ASC : SORT_DESC;
            unset($sort["{$divestore}.updated_at"]);
        }
        if(!empty($coachCount)  && in_array($coachCount,[1,2])){
            $sort["{$divestore}.coach_count"] = 1 == $coachCount ? SORT_ASC : SORT_DESC;
            unset($sort["{$divestore}.updated_at"]);
        }
        if(!empty($language)){
            $userLanguage = Language::tableName();
            $condition["{$userLanguage}.language_id"] = explode(',',$language);
            $query->innerJoinWith('language');
        }
        $query->andWhere($condition);
        $query->orderBy($sort);

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
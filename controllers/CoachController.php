<?php
/**
 * Created by PhpStorm.
 * User: liuzhen12
 * Date: 17-7-5
 * Time: 上午11:35
 */

namespace app\controllers;


use app\components\base\BaseController;
use app\models\User2;
use app\models\UserLanguage;
use Yii;
use yii\data\ActiveDataProvider;

class CoachController extends BaseController
{
    public $modelClass = 'app\models\User2';

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
            'scenario' => $modelClass::SCENARIO_VIEW,
        ];
        return $actions;
    }

    public function prepareDataProvider()
    {
        $country =  Yii::$app->getRequest()->get('country');
        $province =  Yii::$app->getRequest()->get('province');
        $city =  Yii::$app->getRequest()->get('city');
        $gender = Yii::$app->getRequest()->get('gender');
        $language = Yii::$app->getRequest()->get('language');
        $evaluationScore = Yii::$app->getRequest()->get('evaluation_score');
        $studentCount = Yii::$app->getRequest()->get('student_count');

        $User2 = User2::tableName();
        $condition = [];
        $sort = ["{$User2}.updated_at"=>SORT_DESC];
        $query = User2::find()
            ->select(implode(',',array_merge((new User2(['scenario' => User2::SCENARIO_INDEX]))->activeAttributes(),['user.id'])));
        if(!empty($country)){
            $condition["{$User2}.country"] = $country;
        }
        if(!empty($province)){
            $condition["{$User2}.province"] = $province;
        }
        if(!empty($city)){
            $condition["{$User2}.city"] = $city;
        }
        if(!empty($gender)){
            $condition["{$User2}.gender"] = explode(',',$gender);
        }
        if(!empty($evaluationScore) && in_array($evaluationScore,[1,2])){
            $sort["{$User2}.evaluation_score"] = 1 == $evaluationScore ? SORT_ASC : SORT_DESC;
            unset($sort["{$User2}.updated_at"]);
        }
        if(!empty($studentCount)  && in_array($studentCount,[1,2])){
            $sort["{$User2}.student_count"] = 1 == $studentCount ? SORT_ASC : SORT_DESC;
            unset($sort["{$User2}.updated_at"]);
        }
        if(!empty($language)){
            $userLanguage = UserLanguage::tableName();
            $condition["{$userLanguage}.language_id"] = explode(',',$language);
            $query->innerJoinWith('userLanguage');
        }
        $query->andWhere($condition);
        $query->orderBy($sort);

        return Yii::createObject([
            'class' => ActiveDataProvider::className(),
            'query' => $query,
            'pagination' => [
                'pageSize' => 5,
            ],
//            'sort' => [
//                'defaultOrder' => $sort,
//            ],
        ]);
    }
}
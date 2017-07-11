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

        $condition = [];
        $sort = ['updated_at'=>SORT_DESC];
        if(!empty($country)){
            $condition['country'] = $country;
        }
        if(!empty($province)){
            $condition['province'] = $province;
        }
        if(!empty($city)){
            $condition['city'] = $city;
        }
        if(!empty($gender)){
            $condition['gender'] = explode(',',$gender);
        }
        if(!empty($language)){
            $condition['language_detail'] = explode(',',$language);
        }
        if(!empty($evaluationScore) && in_array($evaluationScore,[0,1])){
            $sort['evaluation_score'] = 1 == $evaluationScore ? SORT_DESC : SORT_ASC;
            unset($sort['updated_at']);
        }
        if(!empty($studentCount)  && in_array($studentCount,[0,1])){
            $sort['student_count'] = 1 == $studentCount ? SORT_DESC : SORT_ASC;
            unset($sort['updated_at']);
        }

        return Yii::createObject([
            'class' => ActiveDataProvider::className(),
            'query' => User2::find()
                ->select(implode(',',array_merge((new User2(['scenario' => User2::SCENARIO_INDEX]))->activeAttributes(),['id'])))
                ->andWhere($condition),
            'pagination' => [
                'pageSize' => 5,
            ],
            'sort' => [
                'defaultOrder' => $sort,
            ],
        ]);
    }
}
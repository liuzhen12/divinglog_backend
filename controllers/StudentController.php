<?php
/**
 * Created by PhpStorm.
 * User: liuzhen12
 * Date: 17-7-2
 * Time: 下午2:41
 */

namespace app\controllers;


use app\components\base\BaseController;
use app\models\Certification;
use app\models\User;
use Yii;
use yii\data\ActiveDataProvider;

class StudentController extends BaseController
{
    public $modelClass = 'app\models\Certification';

    public function actions()
    {
        return [
            'index' => [
                'class' => 'app\components\base\BaseIndexAction',
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],
                'prepareDataProvider' => [$this, 'prepareDataProvider']
            ]
        ];
    }

    public function prepareDataProvider()
    {
        return Yii::createObject([
            'class' => ActiveDataProvider::className(),
            'query' => Certification::find()->joinWith('diver')
                ->select(implode(',',(new User(['scenario' => User::SCENARIO_STUDENT]))->activeAttributes()))
                ->where(['coach_id' => Yii::$app->user->id])
                ->distinct(),
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);
    }
}
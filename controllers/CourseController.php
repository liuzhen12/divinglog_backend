<?php
/**
 * Created by PhpStorm.
 * User: liuzhen12
 * Date: 17-5-16
 * Time: 下午7:43
 */

namespace app\controllers;


use app\components\base\BaseController;
use app\models\Course;
use Yii;
use yii\data\ArrayDataProvider;

class CourseController extends BaseController
{
    public $modelClass = 'app\models\Course';

    public function actions()
    {
        $actions = parent::actions();
        $modelClass = $this->modelClass;
        $actions['index'] = [
            'class' => 'app\components\base\BaseIndexAction',
            'modelClass' => $modelClass,
            'checkAccess' => [$this, 'checkAccess'],
            'prepareDataProvider' => [$this, 'prepareDataProvider']
        ];
        return $actions;
    }

    public function prepareDataProvider()
    {
        $p_id = intval(Yii::$app->request->get('p_id'));
        $models = Yii::$app->db->cache(function ($db) use ($p_id) {
            return Course::find()->select((new Course(['scenario' => Course::SCENARIO_INDEX]))->activeAttributes())->andWhere(['p_id' => $p_id])->orderBy(['name' => SORT_ASC])->createCommand()->queryAll();
        });

        return Yii::createObject([
            'class' => ArrayDataProvider::className(),
            'allModels' => $models,
            'pagination' => [
                'pageSize' => 0,
            ],
        ]);
    }
}
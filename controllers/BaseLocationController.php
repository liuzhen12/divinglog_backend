<?php
/**
 * Created by PhpStorm.
 * User: liuzhen12
 * Date: 17-7-10
 * Time: 下午3:42
 */

namespace app\controllers;


use app\models\BaseLocation;
use Yii;
use yii\data\ArrayDataProvider;
use yii\rest\ActiveController;

class BaseLocationController extends ActiveController
{
    public $modelClass = 'app\models\BaseLocation';

    public function actions()
    {
        $actions = parent::actions();
        $modelClass = $this->modelClass;
        $actions['index'] = [
            'class' => 'app\components\base\BaseIndexAction',
            'modelClass' => $modelClass,
            'checkAccess' => [$this, 'checkAccess'],
            'prepareDataProvider' => [$this,'prepareDataProvider']
        ];
        return $actions;
    }

    public function prepareDataProvider()
    {
        $p_id= intval(Yii::$app->request->get('p_id'));
        $models = Yii::$app->db->cache(function ($db) use ($p_id) {
            return BaseLocation::find()->select((new BaseLocation(['scenario' => BaseLocation::SCENARIO_INDEX]))->activeAttributes())->andWhere(['p_id' => $p_id])->orderBy(['name'=>SORT_ASC])->createCommand()->queryAll();
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
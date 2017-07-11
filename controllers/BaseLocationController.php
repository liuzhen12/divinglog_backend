<?php
/**
 * Created by PhpStorm.
 * User: liuzhen12
 * Date: 17-7-10
 * Time: 下午3:42
 */

namespace app\controllers;


use app\components\base\BaseController;
use app\models\BaseLocation;
use Yii;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;

class BaseLocationController extends BaseController
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
        $p_id=Yii::$app->request->get('p_id');
        $models = Yii::$app->db->cache(function ($db) use ($p_id) {
//            return $db->createCommand("SELECT * FROM base_location where p_id = {$p_id} ORDER BY name")->queryAll();
            return BaseLocation::find()->andWhere(['p_id' => $p_id])->orderBy(['name'=>SORT_ASC])->createCommand()->queryAll();
        });

        return Yii::createObject([
            'class' => ArrayDataProvider::className(),
            'allModels' => $models,
            'pagination' => [
                'pageSize' => 10,
            ],
//            'sort' => [
//                'defaultOrder' => [
//                    'name'=>SORT_ASC
//                ]
//            ],
        ]);
    }

}
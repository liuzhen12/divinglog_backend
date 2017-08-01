<?php
/**
 * Created by PhpStorm.
 * User: liuzhen12
 * Date: 17-7-2
 * Time: 下午8:11
 */

namespace app\controllers;


use app\models\BaseLanguage;
use Yii;
use yii\data\ArrayDataProvider;
use yii\rest\ActiveController;

class BaseLanguageController extends ActiveController
{
    public $modelClass = 'app\models\BaseLanguage';

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
        $models = Yii::$app->db->cache(function ($db) {
            return BaseLanguage::find()->select((new BaseLanguage(['scenario' => BaseLanguage::SCENARIO_INDEX]))->activeAttributes())->createCommand()->queryAll();
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
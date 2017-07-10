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
        return Yii::createObject([
            'class' => ActiveDataProvider::className(),
            'query' => BaseLocation::find()->andWhere(['p_id' => intval(Yii::$app->request->get('p_id'))]),
            'pagination' => [
                'pageSize' => 0,
            ],
            'sort' => [
                'defaultOrder' => [
                    'name'=>SORT_ASC
                ]
            ],
        ]);
    }
}
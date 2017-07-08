<?php
/**
 * Created by PhpStorm.
 * User: liuzhen12
 * Date: 17-7-5
 * Time: 下午4:39
 */

namespace app\controllers;


use app\components\base\BaseController;
use app\models\Location;
use Yii;
use yii\data\ActiveDataProvider;

class LocationController extends BaseController
{
    public $modelClass = 'app\models\Location';

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
            'query' => Location::find()->andWhere(['source' => intval(Yii::$app->request->get('source'))]),
//            'pagination' => [
//                'pageSize' => $this->pageSize,
//            ],
            'sort' => [
                'defaultOrder' => [
                    'in_count'=>SORT_DESC
                ]
            ],
        ]);
    }
}
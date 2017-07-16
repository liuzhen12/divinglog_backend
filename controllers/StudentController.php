<?php
/**
 * Created by PhpStorm.
 * User: liuzhen12
 * Date: 17-7-2
 * Time: 下午2:41
 */

namespace app\controllers;


use app\components\base\BaseController;
use app\components\tool\TransferView;
use app\models\Certification;
use app\models\User;
use app\models\User1;
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
        $depends_id = TransferView::receive();
        return Yii::createObject([
            'class' => ActiveDataProvider::className(),
            'query' => User1::find()->joinWith('certification')
                ->select(implode(',',(new User1(['scenario' => User::SCENARIO_STUDENT]))->activeAttributes()))
                ->where(['coach_id' => isset($depends_id)? $depends_id : Yii::$app->user->id])
                ->distinct(),
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);
    }
}
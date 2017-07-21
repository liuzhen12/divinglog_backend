<?php
/**
 * Created by PhpStorm.
 * User: liuzhen12
 * Date: 17-5-16
 * Time: 下午7:36
 */

namespace app\controllers;


use app\components\base\BaseController;
use app\components\tool\TransferView;
use app\models\Certification;
use app\models\User;
use app\models\User1;
use Yii;
use yii\data\ActiveDataProvider;

class CertificationController extends BaseController
{
    public $modelClass = 'app\models\Certification';

    public function init()
    {
        parent::init();
        $this->createScenario = Certification::SCENARIO_CERTIFICATE;
        $this->updateScenario = Certification::SCENARIO_EVALUATE;
    }

    public function actions()
    {
        $actions = parent::actions();
        $actions['index'] = [
            'class' => 'app\components\base\BaseIndexAction',
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
            'prepareDataProvider' => [$this, 'prepareDataProvider']
        ];
        $actions['update'] = [
            'class' => 'app\actions\certification\UpdateAction',
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
            'scenario' => $this->updateScenario,
        ];
        return $actions;
    }

    public function prepareDataProvider()
    {
        $depends_id = TransferView::receive();
        Yii::$app->request->setQueryParams(array_merge(Yii::$app->request->getQueryParams(),['expand'=>'avatar_url,nick_name,remark_time']));
        return Yii::createObject([
            'class' => ActiveDataProvider::className(),
            'query' => certification::find()
                ->where(['coach_id' => isset($depends_id)? $depends_id : Yii::$app->user->id]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
    }
}
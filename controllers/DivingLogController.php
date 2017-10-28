<?php
/**
 * Created by PhpStorm.
 * User: liuzhen12
 * Date: 17-5-16
 * Time: 下午7:45
 */

namespace app\controllers;


use app\components\base\BaseController;
use app\components\tool\TransferView;
use app\models\DivingLog;
use app\models\User1;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;

class DivingLogController extends BaseController
{
    public $modelClass = 'app\models\DivingLog';

    public $serializer = [
        'class' => 'app\components\base\BaseSerializer',
        'collectionEnvelope' => 'items',
        'extraLinksClosure' => 'getExtraLinks',
    ];

    public function actions()
    {
        $actions = parent::actions();
        $modelClass = $this->modelClass;
        $actions['index'] = [
            'class' => 'app\components\base\BaseIndexAction',
            'modelClass' => $modelClass,
            'checkAccess' => [$this, 'checkAccess'],
            'scenario' => $modelClass::SCENARIO_DIVER_INDEX,
            'prepareDataProvider' => [$this, 'prepareDataProvider']
        ];
        $actions['create'] = [
            'class' => 'app\actions\divingLog\CreateAction',
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
            'scenario' => $this->createScenario,
        ];
        $actions['delete'] = [
            'class' => 'app\actions\divingLog\DeleteAction',
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
        ];
        $actions['update'] = [
            'class' => 'app\actions\divingLog\UpdateAction',
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
        ];
        $actions['view'] = [
            'class' => 'app\components\base\BaseViewAction',
            'modelClass' => $modelClass,
            'checkAccess' => [$this, 'checkAccess'],
            'scenario' => $modelClass::SCENARIO_VIEW,
        ];
        return $actions;
    }

    public function getExtraLinks()
    {
        $extra = [];
        if(Yii::$app->user->identity->role == User1::ROLE) {
            $extra['create'] = Url::to(['@web/diving-logs'], true);
            $extra['upload'] = Url::to(['@web/upload'], true);
            $extra['mine'] =  Url::to(['@web/divers/'.Yii::$app->user->id.'/diving-logs'], true);
        }
        return $extra;
    }

    public function prepareDataProvider()
    {
        list($depends_id,$depends_obj) = TransferView::receive();

        $model = new DivingLog(['scenario' => DivingLog::SCENARIO_DIVER_INDEX]);

        $query = DivingLog::find()->select(implode(',',array_merge($model->activeAttributes(),['id'])));

        if(isset($depends_id)){
            $query->andWhere(['user_id'=>$depends_id]);
        } else {
            $query->andWhere(['>','stamp',0]);
        }

        return Yii::createObject([
            'class' => ActiveDataProvider::className(),
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'defaultOrder' => [
                    'updated_at' => SORT_DESC
                ]
            ],
        ]);
    }
}
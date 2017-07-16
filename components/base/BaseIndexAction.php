<?php
/**
 * Created by PhpStorm.
 * User: liuzhen12
 * Date: 17-7-1
 * Time: 下午1:57
 */

namespace app\components\base;

use app\components\tool\TransferView;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class BaseIndexAction extends \yii\rest\IndexAction
{
    public $scenario = Model::SCENARIO_DEFAULT;
    public $identity = "user_id";
    public $pageSize = 10;
    public $whereCondition;
    public $sort = ['updated_at' => SORT_DESC];

    protected function prepareDataProvider()
    {
        $depends_id = TransferView::receive();
        if ($this->prepareDataProvider !== null) {
            return call_user_func($this->prepareDataProvider, $this);
        }

        /* @var $modelClass \yii\db\BaseActiveRecord */
        $modelClass = $this->modelClass;
        $model = new $modelClass(['scenario' => $this->scenario]);
        return Yii::createObject([
            'class' => ActiveDataProvider::className(),
            'query' => $modelClass::find()->select(implode(',',array_merge($model->activeAttributes(),['id'])))->andWhere($this->whereCondition?:[$this->identity => isset($depends_id)?:Yii::$app->user->id]),
            'pagination' => [
                'pageSize' => $this->pageSize,
            ],
            'sort' => [
                'defaultOrder' => $this->sort
            ],
        ]);
    }
}
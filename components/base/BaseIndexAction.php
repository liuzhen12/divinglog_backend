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
    public $ignoreAccessToken = false;
    public $sort = ['updated_at' => SORT_DESC];

    protected function prepareDataProvider()
    {
        list($depends_id,$depends_obj) = TransferView::receive();
        if ($this->prepareDataProvider !== null) {
            return call_user_func($this->prepareDataProvider, $this);
        }

        /* @var $modelClass \yii\db\BaseActiveRecord */
        $modelClass = $this->modelClass;
        $model = new $modelClass(['scenario' => $this->scenario]);
        $where = [];
        if(!empty($this->whereCondition)){
            $where = $this->whereCondition;
        } else {
            if ($this->ignoreAccessToken){
                if(isset($depends_id)){
                    $where[$this->identity] = $depends_id;
                }
            } else {
                $where[$this->identity] = isset($depends_id)? $depends_id :Yii::$app->user->id;
            }
        }
//        $this->whereCondition?:[$this->identity => isset($depends_id)? $depends_id :Yii::$app->user->id]
        return Yii::createObject([
            'class' => ActiveDataProvider::className(),
            'query' => $modelClass::find()->select(implode(',',array_merge($model->activeAttributes(),['id'])))->andWhere($where),
            'pagination' => [
                'pageSize' => $this->pageSize,
            ],
            'sort' => [
                'defaultOrder' => $this->sort
            ],
        ]);
    }
}
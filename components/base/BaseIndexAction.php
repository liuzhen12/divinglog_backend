<?php
/**
 * Created by PhpStorm.
 * User: liuzhen12
 * Date: 17-7-1
 * Time: 下午1:57
 */

namespace app\components\base;

use app\models\DivingLog;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\web\ServerErrorHttpException;

class BaseIndexAction extends \yii\rest\IndexAction
{
    public $scenario = Model::SCENARIO_DEFAULT;
    public $identity = "user_id";

    protected function prepareDataProvider()
    {
        if ($this->prepareDataProvider !== null) {
            return call_user_func($this->prepareDataProvider, $this);
        }

        /* @var $modelClass \yii\db\BaseActiveRecord */
        $modelClass = $this->modelClass;
        $model = new $modelClass(['scenario' => $this->scenario]);

        return Yii::createObject([
            'class' => ActiveDataProvider::className(),
            'query' => $modelClass::find()->select(implode(',',array_merge($model->activeAttributes(),['id'])))->where([$this->identity => Yii::$app->user->id]),
            'pagination' => [
                'pageSize' => 5,
            ],
            'sort' => [
                'defaultOrder' => [
                    'updated_at' => SORT_DESC
                ]
            ],
        ]);
    }
}
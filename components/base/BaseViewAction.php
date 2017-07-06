<?php
/**
 * Created by PhpStorm.
 * User: liuzhen12
 * Date: 17-7-6
 * Time: 下午1:51
 */

namespace app\components\base;


use yii\rest\ViewAction;
use yii\base\Model;

class BaseViewAction extends ViewAction
{
    public $scenario = Model::SCENARIO_DEFAULT;

    public function run($id)
    {
        $model = parent::run($id);
        $model->scenario = $this->scenario;
        return $model;
    }
}
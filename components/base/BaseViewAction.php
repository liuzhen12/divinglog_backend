<?php
/**
 * Created by PhpStorm.
 * User: liuzhen12
 * Date: 17-7-6
 * Time: 下午1:51
 */

namespace app\components\base;


use app\components\tool\TransferView;
use yii\rest\ViewAction;
use yii\base\Model;

class BaseViewAction extends ViewAction
{
    public $scenario = Model::SCENARIO_DEFAULT;

    public function run($id,$transfer=null)
    {
        if(isset($transfer)){
            return TransferView::transfer($id,$transfer);
        }

        $model = parent::run($id);
        $model->scenario = $this->scenario;
        return $model;
    }
}
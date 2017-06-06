<?php
/**
 * Created by PhpStorm.
 * User: liuzhen12
 * Date: 17-5-24
 * Time: 上午11:36
 */

namespace app\actions\divingLog;

use app\components\traits\ModelFindingTrait;

class DeleteAction extends \yii\rest\DeleteAction
{
    use ModelFindingTrait;

    public function run($id)
    {
        $model = $this->findModel($id);
        //日志记录删除之后，所属用户日志数减少
        $diver = $model->diver;
        if(isset($diver)){
            $diver->decrLogCount();
        }

        try{
            parent::run($id);

        } catch (\Exception $e){
            if(isset($diver)){
                $diver->incrLogCount();
            }
            throw $e;
        }
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: liuzhen12
 * Date: 17-6-6
 * Time: 下午3:40
 */

namespace app\actions\speciality;

use app\components\traits\ModelFindingTrait;

class DeleteAction extends \yii\rest\DeleteAction
{
    use ModelFindingTrait;

    public function run($id)
    {
        $model = $this->findModel($id);
        //装备删除之后，所属用户装备数减少
        $diver = $model->diver;
        if(isset($diver)){
            $diver->decrSpecialityCount();
        }

        try{
            parent::run($id);

        } catch (\Exception $e){
            if(isset($diver)){
                $diver->incrSpecialityCount();
            }
            throw $e;
        }
    }
}
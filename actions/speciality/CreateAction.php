<?php
/**
 * Created by PhpStorm.
 * User: liuzhen12
 * Date: 17-6-6
 * Time: 下午2:57
 */

namespace app\actions\speciality;


class CreateAction extends \yii\rest\CreateAction
{
    /**
     * Name: run
     * Desc: 扩展原有功能，装备正常添加之后，加入特殊逻辑
     * Creator: liuzhen<liuzhen12@lenovo.com>
     * CreatedDate: 20170606
     * Modifier:
     * ModifiedDate:
     */
    public function run()
    {
        $model = parent::run();
        //装备记录成功之后，所属用户装备数增加
        try{
            $diver = $model->diver;
            if(isset($diver)){
                $diver->incrSpecialityCount();
            }
        } catch (\Exception $e){
            $model->delete();
            throw $e;
        }

        return $model;
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: liuzhen12
 * Date: 17-5-23
 * Time: 下午4:46
 */

namespace app\actions\divingLog;


use yii\web\HttpException;

class CreateAction extends \yii\rest\CreateAction
{

    /**
     * Name: run
     * Desc: 扩展原有日志功能，日志正常添加之后，加入特殊逻辑
     * Creator: liuzhen<liuzhen12@lenovo.com>
     * CreatedDate: 20170523
     * Modifier:
     * ModifiedDate:
     */
    public function run()
    {
        var_dump($_FILES);exit;
        $model = parent::run();
        //日志记录成功之后，所属用户日志数增加
        try{
            $diver = $model->diver;
            if(isset($diver)){
                $diver->incrLogCount();
            }
        } catch (HttpException $e){
            $model->delete();
            throw $e;
        }

        return $model;
    }
}
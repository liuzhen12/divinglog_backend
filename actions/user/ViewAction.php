<?php

namespace app\actions\user;

/**
 * Created by PhpStorm.
 * User: liuzhen12
 * Date: 17-7-2
 * Time: 下午4:50
 */
class ViewAction extends \yii\rest\ViewAction
{
    public function run($id)
    {
        $model = parent::run($id);
        return $model;
    }
}
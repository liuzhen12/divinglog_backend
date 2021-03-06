<?php
/**
 * Created by PhpStorm.
 * User: liuzhen12
 * Date: 17-8-12
 * Time: 下午4:37
 */

namespace app\modules\wechat\controllers;


use yii\rest\ActiveController;

class UploadController extends ActiveController
{
    public $modelClass = 'app\components\tool\UploadModel';

    public function actions()
    {
        return [
            'create' => [
                'class' => 'app\modules\wechat\actions\upload\CreateAction',
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],
            ]
        ];
    }
}
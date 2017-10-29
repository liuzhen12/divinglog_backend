<?php

namespace app\modules\wechat\actions\upload;

use yii;
use yii\web\UploadedFile;
use app\components\tool\UploadModel;

/**
 * Created by PhpStorm.
 * User: liuzhen12
 * Date: 17-5-19
 * Time: 下午2:06
 */
class CreateAction extends \yii\rest\CreateAction
{

    /**
     * Name: run
     * Desc: 在调用主体逻辑之前，对request做转化
     * Creator: liuzhen<liuzhen12@lenovo.com>
     * CreatedDate: 20170523
     * Modifier:
     * ModifiedDate:
     * @return yii\db\ActiveRecordInterface
     */
    public function run()
    {
        $uploadModel = new UploadModel(['scenario' => 'images']);
        $uploadModel->load(Yii::$app->getRequest()->getBodyParams(), '');
        if($uploadModel->save()){
            $response = Yii::$app->getResponse();
            $response->setStatusCode(201);
        }elseif (!$uploadModel->hasErrors()) {
            throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
        }
        return $uploadModel;
    }
}
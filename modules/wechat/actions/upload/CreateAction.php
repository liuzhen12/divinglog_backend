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
        var_dump($_FILES);
        $uploadModel = new UploadModel();
        $uploadModel->images = UploadedFile::getInstances($uploadModel, 'images');
        var_dump($uploadModel);exit;
        return parent::run();
    }
}
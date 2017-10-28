<?php
/**
 * Created by PhpStorm.
 * User: liuzhen12
 * Date: 17-8-12
 * Time: 下午3:23
 */

namespace app\components\tool;


use Yii;
use yii\base\Model;
use yii\helpers\FileHelper;

class UploadModel extends Model
{
    public $images;
    public $filePath;

//    public $thumbnails;
//
//    public function scenarios()
//    {
//        return [
//            'attachment' => ['images','thumbnails'],
//        ];
//    }

    public function rules()
    {
        return [
            ['images', 'file', 'extensions' => ['png', 'jpg', 'gif'], 'maxSize' => 1024*1024, 'maxFiles' => 6],
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            $newNames = [];
            $dirName = Yii::getAlias('@app') . '/runtime';
            if (!file_exists($dirName)) {
                FileHelper::createDirectory($dirName);
            }
            foreach ($this->images as $file) {
                $newFileName = uniqid().mt_rand(1,99) . '.' . $file->extension;
                if ($file->saveAs($dirName . '/' . $newFileName)) {
                    $newNames[] = $dirName . '/' . $newFileName;
                }
            }
            if ($newNames) {
                $this->filePath = $newNames;
            }
            return true;
        }
        return false;
    }
}
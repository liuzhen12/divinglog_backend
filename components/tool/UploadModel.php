<?php
/**
 * Created by PhpStorm.
 * User: liuzhen12
 * Date: 17-8-12
 * Time: 下午3:23
 */

namespace app\components\tool;


use Yii;
use yii\base\Exception;
use yii\base\Model;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

class UploadModel extends Model
{
    public $files;
    public $abandons;
    public $filePath;

//    public $thumbnails;
//
    public function scenarios()
    {
        return [
            'images' => ['files'],
        ];
    }

    public function rules()
    {
        return [
            ['files', 'file', 'extensions' => ['png', 'jpg', 'gif'], 'maxSize' => 1024*1024, 'maxFiles' => 6, 'on' => 'images'],
        ];
    }

    public function load($data, $formName = null)
    {
        try{
            $this->files = UploadedFile::getInstances($this, 'files');
        } catch (Exception $e){
            return false;
        }
        return true;
    }

    public function save()
    {
        if ($this->validate()) {
            $newNames = [];
            $dirName = Yii::getAlias('@app') . '/web/files';
            if (!file_exists($dirName)) {
                FileHelper::createDirectory($dirName);
            }
            foreach ($this->files as $file) {
                $newFileName = uniqid().mt_rand(1,99) . '.' . $file->extension;

                if ($file->saveAs($dirName . '/' . $newFileName)) {
                    $newNames[] = $dirName . '/' . $newFileName;
                }
            }
            if ($newNames) {
                $this->filePath = "files/{$newFileName}";
            }
            return true;
        }
        return false;
    }
}
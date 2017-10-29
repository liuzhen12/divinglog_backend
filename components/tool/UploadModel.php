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
    public $thumbWidth;
    public $thumbHeight;
    public $thumbSuffix = '_thumb';

    public function scenarios()
    {
        return [
            'images' => ['files'],
        ];
    }

    public function rules()
    {
        return [
            ['files', 'file', 'extensions' => ['png', 'jpg', 'gif'], 'maxSize' => 1024*1024*10, 'maxFiles' => 6, 'on' => 'images'],
            ['thumbWidth', 'integer'],
            ['thumbHeight', 'integer'],
        ];
    }

    public function load($data, $formName = null)
    {
        try{
            $this->files = UploadedFile::getInstances($this, 'files');
            foreach ($data as $k=>$v){
                $this->$k = $v;
            }
        } catch (Exception $e){
            return false;
        }
        return true;
    }

    public function fields()
    {
        return ['filePath'];
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
            if($this->thumbWidth > 0 && $this->thumbHeight > 0){
                $img = new Image(Yii::getAlias('@app') . '/web/'.$this->filePath);
                $img->thumb($this->thumbWidth, $this->thumbHeight);
                $img->out($this->thumbSuffix);
            }
            return true;
        }
        return false;
    }

    public function delete()
    {
        if(isset($this->abandons)){
            if(is_string($this->abandons)){
                $this->abandons = explode(",",$this->abandons);
            }
            if(!is_array($this->abandons)){
                return false;
            }
            $dirName = Yii::getAlias('@app') . '/web/';
            foreach ($this->abandons as $abandon){
                @unlink($dirName.$abandon);
                @unlink(Image::addSuffix($dirName.$abandon));
            }
        }
        return true;
    }
}
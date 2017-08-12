<?php
/**
 * Created by PhpStorm.
 * User: liuzhen12
 * Date: 17-8-12
 * Time: 下午3:23
 */

namespace app\components\tool;


use yii\base\Model;

class UploadModel extends Model
{
    public $images;

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
}
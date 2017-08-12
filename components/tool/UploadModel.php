<?php
/**
 * Created by PhpStorm.
 * User: liuzhen12
 * Date: 17-8-12
 * Time: 下午3:23
 */

namespace app\components\tool;


class UploadModel extends Model
{
    public $images;

    public $thumbnails;

    public function scenarios()
    {
        return [
            'attachment' => ['images','thumbnails'],
        ];
    }
}
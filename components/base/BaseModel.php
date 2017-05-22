<?php
/**
 * Created by PhpStorm.
 * User: liuzhen12
 * Date: 17-5-16
 * Time: 下午3:24
 */

namespace app\components\base;


use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\web\Linkable;


class BaseModel extends ActiveRecord implements Linkable
{
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
            ],
        ];
    }

    public function fields()
    {
        $fields = parent::fields();

        // remove fields that contain sensitive information
        unset($fields['created_at'], $fields['updated_at']);

        return $fields;
    }

    public function getLinks()
    {
        return [];
    }
}
<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_language".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $language_id
 * @property integer $created_at
 * @property integer $updated_at
 */
class UserLanguage extends \app\components\base\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_language';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'language_id', 'created_at', 'updated_at'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', '用户id,关联user'),
            'language_id' => Yii::t('app', '语言id,关联language'),
            'created_at' => Yii::t('app', '创建时间戳'),
            'updated_at' => Yii::t('app', '更新时间戳'),
        ];
    }
}

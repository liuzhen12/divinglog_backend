<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "activity_member".
 *
 * @property integer $id
 * @property integer $activity_id
 * @property integer $user_id
 * @property integer $created_at
 * @property integer $updated_at
 */
class ActivityMember extends \app\components\base\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'activity_member';
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors[] = [
            'class' => 'app\components\behavior\UserImpressionBehavior',
            'supporter' => $this
        ];
        return $behaviors;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['activity_id', 'user_id', 'created_at', 'updated_at'], 'integer'],
            ['user_id', 'unique', 'targetAttribute' => ['activity_id', 'user_id'], 'message' => 'You have already taken part in this activity.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'activity_id' => Yii::t('app', '关联活动'),
            'user_id' => Yii::t('app', '关联用户(潜员,教练)'),
            'created_at' => Yii::t('app', '创建时间戳'),
            'updated_at' => Yii::t('app', '更新时间戳'),
        ];
    }

    public function fields()
    {
        $fields = parent::fields();
        $fields['avatar_url'] = 'avatarUrl';
        $fields['nick_name'] = 'nickName';
        return $fields;
    }
}

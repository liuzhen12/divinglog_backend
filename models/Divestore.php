<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "divestore".
 *
 * @property integer $id
 * @property string $name
 * @property string $telephone
 * @property string $wechat_id
 * @property integer $evaluation_count
 * @property string $evaluation_score
 * @property integer $coach_count
 * @property string $location_longitude
 * @property string $location_latitue
 * @property string $location_name
 * @property string $location_address
 * @property integer $created_at
 * @property integer $updated_at
 */
class Divestore extends \app\components\base\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'divestore';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['evaluation_count', 'coach_count', 'created_at', 'updated_at'], 'integer'],
            [['evaluation_score', 'location_longitude', 'location_latitue'], 'number'],
            [['name', 'wechat_id', 'location_name'], 'string', 'max' => 45],
            [['telephone'], 'string', 'max' => 20],
            [['location_address'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', '潜店名字'),
            'telephone' => Yii::t('app', '潜店电话'),
            'wechat_id' => Yii::t('app', '微信号或者qq号码或者手机号码，反正是可以直接加好友的ID'),
            'evaluation_count' => Yii::t('app', '评价次数'),
            'evaluation_score' => Yii::t('app', '评价平均分'),
            'coach_count' => Yii::t('app', '教练人数'),
            'location_longitude' => Yii::t('app', '微信定位-经度'),
            'location_latitue' => Yii::t('app', '微信定位-纬度'),
            'location_name' => Yii::t('app', '微信定位-位置名称'),
            'location_address' => Yii::t('app', '微信定位-详细地址'),
            'created_at' => Yii::t('app', '创建时间戳'),
            'updated_at' => Yii::t('app', '更新时间戳'),
        ];
    }
}

<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "activity".
 *
 * @property integer $id
 * @property integer $type
 * @property string $title
 * @property integer $user_id
 * @property string $start_date
 * @property string $end_date
 * @property string $location_longitude
 * @property string $location_latitue
 * @property string $location_name
 * @property string $location_address
 * @property string $dive_point
 * @property integer $max_member
 * @property integer $accommodation
 * @property integer $participants_count
 * @property integer $created_at
 * @property integer $updated_at
 */
class Activity extends \app\components\base\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'activity';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'user_id', 'max_member', 'accommodation', 'participants_count', 'created_at', 'updated_at'], 'integer'],
            [['start_date', 'end_date'], 'safe'],
            [['location_longitude', 'location_latitue'], 'number'],
            [['title'], 'string', 'max' => 30],
            [['location_name', 'dive_point'], 'string', 'max' => 45],
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
            'type' => Yii::t('app', '1: 約伴'),
            'title' => Yii::t('app', '活动标题'),
            'user_id' => Yii::t('app', '发起人'),
            'start_date' => Yii::t('app', '活动开始日期'),
            'end_date' => Yii::t('app', '活动结束日期'),
            'location_longitude' => Yii::t('app', '微信定位-经度'),
            'location_latitue' => Yii::t('app', '微信定位-纬度'),
            'location_name' => Yii::t('app', '微信定位-位置名称'),
            'location_address' => Yii::t('app', '微信定位-详细地址'),
            'dive_point' => Yii::t('app', '潜点名字'),
            'max_member' => Yii::t('app', '活动人数设定上限'),
            'accommodation' => Yii::t('app', '住宿: 1 酒店 2 船潜'),
            'participants_count' => Yii::t('app', '已报名人数'),
            'created_at' => Yii::t('app', '创建时间戳'),
            'updated_at' => Yii::t('app', '更新时间戳'),
        ];
    }
}

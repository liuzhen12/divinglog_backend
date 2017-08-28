<?php

namespace app\models;

use Yii;
use yii\helpers\Url;
use yii\web\Link;

/**
 * This is the model class for table "diving_log".
 *
 * @property integer $id
 * @property integer $no
 * @property integer $user_id
 * @property string $day
 * @property string $time_in
 * @property string $time_out
 * @property string $location_longitude
 * @property string $location_latitue
 * @property string $location_name
 * @property string $location_address
 * @property string $dive_point
 * @property integer $depth1
 * @property integer $time1
 * @property integer $depth2
 * @property integer $time2
 * @property integer $depth3
 * @property integer $time3
 * @property integer $gas
 * @property integer $barometer_start
 * @property integer $barometer_end
 * @property integer $weight
 * @property string $comments
 * @property string $assets
 * @property integer $stamp
 * @property integer $link_id
 * @property integer $divestore_id
 * @property integer $divestore_score
 * @property integer $created_at
 * @property integer $updated_at
 */
class DivingLog extends \app\components\base\BaseModel
{
    const SCENARIO_INDEX = 'index';
    const SCENARIO_DIVER_INDEX = 'diver_index';
    const SCENARIO_CREATE = 'create';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'diving_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no', 'user_id', 'depth1', 'time1', 'depth2', 'time2', 'depth3', 'time3', 'gas', 'barometer_start', 'barometer_end', 'weight', 'stamp','link_id','divestore_id', 'divestore_score', 'created_at', 'updated_at'], 'integer'],
            [['day', 'time_in', 'time_out'], 'safe'],
            [['location_longitude', 'location_latitue'], 'number'],
            [['location_name','dive_point'], 'string', 'max' => 45],
            [['location_address'], 'string', 'max' => 200],
            [['comments'], 'string', 'max' => 140],
            [['assets'], 'string', 'max' => 100],
        ];
    }

    public function scenarios()
    {
        return
            array_merge(parent::scenarios(),[
                self::SCENARIO_INDEX => ['user_id', 'day','location_longitude','location_latitue','location_name','location_address','assets'],
                self::SCENARIO_DIVER_INDEX => ['user_id', 'day','location_longitude','location_latitue','location_name','location_address','assets','stamp'],
                self::SCENARIO_CREATE => ['no','user_id','day','time_in','time_out', 'location_longitude', 'location_latitue','location_name', 'location_address', 'dive_point','depth1', 'time1','depth2', 'time2','depth3', 'time3','gas','barometer_start','barometer_end','weight','comments','!assets','link_id','divestore_id','divestore_score'],
            ]);
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'no' => Yii::t('app', '潜水日志，对每个user,连续递增。即使有删除的情况发生，也要保持连续性。'),
            'user_id' => Yii::t('app', '关联潜水员'),
            'day' => Yii::t('app', '潜水日期'),
            'time_in' => Yii::t('app', '入水时间'),
            'time_out' => Yii::t('app', '出水时间'),
            'location_longitude' => Yii::t('app', '微信定位-经度'),
            'location_latitue' => Yii::t('app', '微信定位-纬度'),
            'location_name' => Yii::t('app', '微信定位-位置名称'),
            'location_address' => Yii::t('app', '微信定位-详细地址'),
            'dive_point' => Yii::t('app', '潜点'),
            'depth1' => Yii::t('app', '潜水深度'),
            'time1' => Yii::t('app', '水下时间'),
            'depth2' => Yii::t('app', '潜水深度'),
            'time2' => Yii::t('app', '水下时间'),
            'depth3' => Yii::t('app', '潜水深度'),
            'time3' => Yii::t('app', '水下时间'),
            'gas' => Yii::t('app', '潜水气体 0:air other:高氧 纯氧含量(32代表32%的纯氧)'),
            'barometer_start' => Yii::t('app', '初始压力表数值'),
            'barometer_end' => Yii::t('app', '潜水结束时压力表数值'),
            'weight' => Yii::t('app', '配重'),
            'comments' => Yii::t('app', '潜水的感受和评价'),
            'assets' => Yii::t('app', '潜水照片链接'),
            'stamp' => Yii::t('app', '认证人数和被拷贝的日志数量之和'),
            'link_id' => Yii::t('app', '一次潜水buddies的日志可以通过copy来减少输入量，那么copy出来的日志和被copy的日志维护相同的link_id'),
            'divestore_id' => Yii::t('app', '关联潜店ID'),
            'divestore_score' => Yii::t('app', '给潜店打分'),
            'created_at' => Yii::t('app', '创建时间戳'),
            'updated_at' => Yii::t('app', '更新时间戳'),
        ];
    }

    public function getLinks()
    {
        return [
            Link::REL_SELF => Url::to(['diving-log/view', 'id' => $this->id], true),
            'edit' => Url::to(['diving-log/view', 'id' => $this->id], true),
            'delete' => Url::to(['diving-log/view', 'id' => $this->id], true),
            'index' => Url::to(['@web/diving-logs'],true),
            'create' => Url::to(['@web/diving-logs'], true),
        ];
    }

    /**
     * Name: getDiver
     * Desc: 获取当前日志的潜水员
     * Creator: liuzhen<liuzhen12@lenovo.com>
     * CreatedDate: 20170523
     * Modifier:
     * ModifiedDate:
     * @return array|null|\yii\db\ActiveRecord
     */
    public function getDiver()
    {
        return $this->hasOne(User1::className(),['id'=>'user_id'])->one();
    }

    /**
     * Name: getDivestore
     * Desc: 获取当前日志记录的潜店
     * Creator: liuzhen<liuzhen12@lenovo.com>
     * CreatedDate: 20170523
     * Modifier:
     * ModifiedDate:
     * @return array|null|\yii\db\ActiveRecord
     */
    public function getDivestore()
    {
        return $this->hasOne(Divestore::className(),['id'=>'divestore_id'])->one();
    }
}

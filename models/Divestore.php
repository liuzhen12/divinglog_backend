<?php

namespace app\models;

use app\components\events\LocationEvent;
use Yii;
use yii\helpers\Url;
use yii\web\HttpException;
use yii\web\Link;

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
 * @property string $city
 * @property string $province
 * @property string $country
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
            [['name', 'wechat_id', 'city', 'province', 'country', 'location_name'], 'string', 'max' => 45],
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
            'city' => Yii::t('app', 'City'),
            'province' => Yii::t('app', 'Province'),
            'country' => Yii::t('app', 'Country'),
            'location_longitude' => Yii::t('app', '微信定位-经度'),
            'location_latitue' => Yii::t('app', '微信定位-纬度'),
            'location_name' => Yii::t('app', '微信定位-位置名称'),
            'location_address' => Yii::t('app', '微信定位-详细地址'),
            'created_at' => Yii::t('app', '创建时间戳'),
            'updated_at' => Yii::t('app', '更新时间戳'),
        ];
    }

    public function getLinks()
    {
        return [
            Link::REL_SELF => Url::to(['divestore/view', 'id' => $this->id], true),
            'index' => Url::to(['@web/divestores'], true)
        ];
    }

    /**
     * Name: save
     * Desc: 重写，触发保存location的事件
     * Creator: liuzhen<liuzhen12@lenovo.com>
     * CreatedDate: 20170708
     * Modifier:
     * ModifiedDate:
     * @param bool $runValidation
     * @param null $attributeNames
     * @return bool
     */
    public function save($runValidation = true, $attributeNames = null)
    {
        $data = [];
        $data['country'] = $this->getAttribute('country');
        $data['oldCountry'] = $this->getOldAttribute('country');
        $data['province'] = $this->getAttribute('province');
        $data['oldProvince'] = $this->getOldAttribute('province');
        $data['city'] = $this->getAttribute('city');
        $data['oldCity'] = $this->getOldAttribute('city');
        $result = parent::save($runValidation, $attributeNames);
        if($result){
            //触发保存location的事件
            Yii::$app->trigger(LocationEvent::DIVESTORE,new Event(['sender' => $data]));
        }
        return $result;
    }

    /**
     * Name: evaluation
     * Desc: 店铺评价,更新对应店铺的平均分和评价人数
     * Creator: liuzhen<liuzhen12@lenovo.com>
     * CreatedDate: 20170606
     * Modifier:
     * ModifiedDate:
     * @param $score
     */
    public function evaluation($score)
    {
        $this->evaluation_count++;
        $this->evaluation_score = ($score - $this->evaluation_score) / $this->evaluation_count + $this->evaluation_score ;
        if(!$this->save()){
            throw new HttpException(422, implode('|', $this->getFirstErrors()));
        }
    }
}

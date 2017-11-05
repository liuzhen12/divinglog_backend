<?php

namespace app\models;

use app\components\events\LanguageEvent;
use app\components\events\LocationEvent;
use Yii;
use yii\base\Event;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\HttpException;
use yii\web\Link;

/**
 * This is the model class for table "divestore".
 *
 * @property integer $id
 * @property string $no
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
    const SCENARIO_INDEX = 'index';

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
            [['evaluation_score', 'location_longitude', 'location_latitude'], 'number'],
            [['name', 'wechat_id', 'city', 'province', 'country', 'location_name'], 'string', 'max' => 45],
            [['no','telephone','language_detail'], 'string', 'max' => 20],
            [['location_address','avatar_url','assets'], 'string', 'max' => 200],
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_INDEX] = ['no','name','language_detail','city', 'province', 'country','avatar_url','evaluation_count','evaluation_score','coach_count'];
        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'no' => Yii::t('app', '潜店编号'),
            'name' => Yii::t('app', '潜店名字'),
            'telephone' => Yii::t('app', '潜店电话'),
            'wechat_id' => Yii::t('app', '微信号或者qq号码或者手机号码，反正是可以直接加好友的ID'),
            'evaluation_count' => Yii::t('app', '评价次数'),
            'evaluation_score' => Yii::t('app', '评价平均分'),
            'coach_count' => Yii::t('app', '教练人数'),
            'avatar_url' => Yii::t('app', '店铺門面图片'),
            'assets' => Yii::t('app', '潜店照片链接'),
            'language_detail' => Yii::t('app', '1->中 2->英 3->粤'),
            'city' => Yii::t('app', 'City'),
            'province' => Yii::t('app', 'Province'),
            'country' => Yii::t('app', 'Country'),
            'location_longitude' => Yii::t('app', '微信定位-经度'),
            'location_latitude' => Yii::t('app', '微信定位-纬度'),
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
            'index' => Url::to(['@web/divestores'], true),
            'coach' => Url::to(["@web/divestores/{$this->id}/coaches"], true),
        ];
    }

    public function fields()
    {
        $fields = parent::fields();
        $fields['language_detail'] = 'languageDetail';
        return $fields;
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
        //Language
        $doUpdateLanguage = isset($this->getDirtyAttributes()['language_detail']);
        $languageData = [];
        $languageData['relation_id'] = $this->getAttribute('id');
        $languageData['language_detail'] = $this->getAttribute('language_detail');

        //Location
        $locationData = [];
        $locationData['country'] = $this->getAttribute('country');
        $locationData['oldCountry'] = $this->getOldAttribute('country');
        $locationData['province'] = $this->getAttribute('province');
        $locationData['oldProvince'] = $this->getOldAttribute('province');
        $locationData['city'] = $this->getAttribute('city');
        $locationData['oldCity'] = $this->getOldAttribute('city');

        $result = parent::save($runValidation, $attributeNames);
        if($result){
            //触发保存language的事件
            if($doUpdateLanguage){
                Yii::$app->trigger(LanguageEvent::DIVESTORE,new Event(['sender' => $languageData]));
            }
            //触发保存location的事件
            Yii::$app->trigger(LocationEvent::DIVESTORE,new Event(['sender' => $locationData]));
        }
        return $result;
    }

    /**
     * Name: delete
     * Desc:
     * Creator: liuzhen<liuzhen12@lenovo.com>
     * CreatedDate: 20170731
     * Modifier:
     * ModifiedDate:
     * @return false|int
     */
    public function delete()
    {
        //Language
        $languageData = [];
        $languageData['relation_id'] = $this->getAttribute('id');

        //Location
        $locationData = [];
        $locationData['oldCountry'] = $this->getAttribute('country');
        $locationData['oldProvince'] = $this->getAttribute('province');
        $locationData['oldCity'] = $this->getAttribute('city');
        $result = parent::delete();
        if($result){
            //触发保存language的事件
            Yii::$app->trigger(LanguageEvent::DIVESTORE,new Event(['sender' => $languageData]));
            //触发保存location的事件
            Yii::$app->trigger(LocationEvent::DIVESTORE,new Event(['sender' => $locationData]));
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

    /**
     * Name: getUserLanguage
     * Desc: 获取用户关联的语言
     * Creator: liuzhen<liuzhen12@lenovo.com>
     * CreatedDate: 20170713
     * Modifier:
     * ModifiedDate:
     * @return \yii\db\ActiveQuery
     */
    public function getLanguage()
    {
        return $this->hasMany(Language::className(),['relation_id'=>'id'])->onCondition(['source' => Language::SOURCE_DIVESTORE]);
    }

    /**
     * Name: getLanguageDetail
     * Desc:
     * Creator: liuzhen<liuzhen12@lenovo.com>
     * CreatedDate: 20170803
     * Modifier:
     * ModifiedDate:
     * @return mixed
     */
    public function getLanguageDetail()
    {
        return  Yii::$app->db->cache(function ($db) {
            $query = BaseLanguage::find()->where(['id' => explode(',',$this->language_detail)])->select(['id','name'])->asArray()->all();
            return implode(',',array_values(ArrayHelper::map($query,'id','name')));
        });
    }
}

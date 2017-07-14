<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "location".
 *
 * @property integer $id
 * @property integer $source
 * @property string $name
 * @property string $detail
 * @property integer $in_count
 * @property integer $query_count
 * @property integer $created_at
 * @property integer $updated_at
 */
class Location extends \app\components\base\BaseModel
{
    public $country;
    public $province;
    public $city;
    public $oldCountry;
    public $oldProvince;
    public $oldCity;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'location';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['source', 'in_count', 'query_count', 'created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 45],
            [['detail'], 'string', 'max' => 150],
            [['source', 'name'], 'unique', 'targetAttribute' => ['source', 'name'], 'message' => 'The combination of 1:diver 2:coach 3:divestore and Name has already been taken.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'source' => Yii::t('app', '1:diver 2:coach 3:divestore'),
            'name' => Yii::t('app', 'Name'),
            'detail' => Yii::t('app', 'Detail'),
            'in_count' => Yii::t('app', '地区里的注册人数或者潜店数'),
            'query_count' => Yii::t('app', '被检索次数'),
            'created_at' => Yii::t('app', '创建时间戳'),
            'updated_at' => Yii::t('app', '更新时间戳'),
        ];
    }

    public function fields()
    {
        $fields = parent::fields();
        unset($fields['source']);
        return $fields;
    }

    /**
     * Name: batchSave
     * Desc: 批量添加country,province,city这些location信息
     * Creator: liuzhen<liuzhen12@lenovo.com>
     * CreatedDate: 20170708
     * Modifier:
     * ModifiedDate:
     * @return bool
     */
    public function batchSave()
    {
        $transaction = Yii::$app->getDb()->beginTransaction();
        try {
            if ($this->country <> $this->oldCountry) {
                if (!empty($this->country)) {
                    $country = static::findOne(['source' => $this->source, 'name' => $this->country]) ?: clone $this;
                    $country->source = $this->source;
                    $country->name = $this->country;
                    $country->detail = $this->country;
                    $country->in_count++;
                    $country->save();
                }
                //旧值要减去计数
                if (!empty($this->oldCountry)) {
                    $country = static::findOne(['source' => $this->source, 'name' => $this->oldCountry]);
                    if (isset($country)) {
                        if($country->in_count <= 1){
                            $country->delete();
                        }else {
                            $country->in_count--;
                            $country->save();
                        }
                    }
                }
            }

            if ($this->province <> $this->oldProvince) {
                if (!empty($this->province)) {
                    $province = static::findOne(['source' => $this->source, 'name' => $this->province]) ?: clone $this;
                    $province->source = $this->source;
                    $province->name = $this->province;
                    $province->detail = "{$this->province},{$this->country}";
                    $province->in_count++;
                    $province->save();
                }
                //旧值要减去计数
                if (!empty($this->oldProvince)) {
                    $province = static::findOne(['source' => $this->source, 'name' => $this->oldProvince]);
                    if (isset($province)) {
                        if($province->in_count <= 1){
                            $province->delete();
                        }else {
                            $province->in_count--;
                            $province->save();
                        }
                    }
                }
            }

            if ($this->city <> $this->oldCity) {
                if(!empty($this->province)){
                    $city = static::findOne(['source' => $this->source, 'name' => $this->city]) ?: clone $this;
                    $city->source = $this->source;
                    $city->name = $this->city;
                    $city->detail = "{$this->city},{$this->province},{$this->country}";
                    $city->in_count++;
                    $city->save();
                }
                //旧值要减去计数
                if (!empty($this->oldCity)) {
                    $city = static::findOne(['source' => $this->source, 'name' => $this->oldCity]);
                    if (isset($city)) {
                        if($city->in_count <= 1){
                            $city->delete();
                        }else {
                            $city->in_count--;
                            $city->save();
                        }
                    }
                }
            }
            $transaction->commit();
            return true;
        }catch (\Exception $e){
            $transaction->rollBack();
        }
        return false;
    }
}

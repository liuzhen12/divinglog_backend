<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "equip".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $type
 * @property string $brand
 * @property string $model
 * @property integer $created_at
 * @property integer $updated_at
 */
class Equip extends \app\components\base\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'equip';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'created_at', 'updated_at'], 'integer'],
            [['brand', 'model'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', '关联用户'),
            'type' => Yii::t('app', '类型'),
            'brand' => Yii::t('app', '品牌'),
            'model' => Yii::t('app', '型号'),
            'created_at' => Yii::t('app', '创建时间戳'),
            'updated_at' => Yii::t('app', '更新时间戳'),
        ];
    }

    /**
     * Name: getDiver
     * Desc: 获取当前装备的潜水员
     * Creator: liuzhen<liuzhen12@lenovo.com>
     * CreatedDate: 20170606
     * Modifier:
     * ModifiedDate:
     * @return array|null|\yii\db\ActiveRecord
     */
    public function getDiver()
    {
        return $this->hasOne(User::className(),['id'=>'user_id'])->one();
    }
}

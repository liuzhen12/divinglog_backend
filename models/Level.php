<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "level".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $organization
 * @property string $level
 * @property string $no
 * @property integer $coach_id
 * @property integer $created_at
 * @property integer $updated_at
 */
class Level extends \app\components\base\BaseModel
{
    const SCENARIO_CREATE= 'create';
    const SCENARIO_CERTIFICATE = 'certificate';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'level';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'coach_id', 'created_at', 'updated_at'], 'integer'],
            [['organization'], 'string', 'max' => 45],
            [['level', 'no'], 'string', 'max' => 20],
            [['user_id','organization','level'],'required','on'=>self::SCENARIO_CREATE],
            [['coach_id',],'required','on'=>self::SCENARIO_CERTIFICATE],
        ];
    }

    public function scenarios()
    {
        return [
            self::SCENARIO_CREATE => ['user_id','organization','level'],
            self::SCENARIO_CERTIFICATE => ['coach_id'],
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
            'organization' => Yii::t('app', '组织 PADI'),
            'level' => Yii::t('app', '等级 OW AOW'),
            'no' => Yii::t('app', '编号'),
            'coach_id' => Yii::t('app', '认证的教练'),
            'created_at' => Yii::t('app', '创建时间戳'),
            'updated_at' => Yii::t('app', '更新时间戳'),
        ];
    }

    /**
     * Name: getDiver
     * Desc: 获取当前等级的潜水员
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

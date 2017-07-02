<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "certification".
 *
 * @property integer $id
 * @property integer $log_id
 * @property integer $user_id
 * @property integer $coach_id
 * @property integer $score
 * @property string $remarks
 * @property integer $created_at
 * @property integer $updated_at
 */
class Certification extends \app\components\base\BaseModel
{
    const SCENARIO_CERTIFICATE = 'certificate';
    const SCENARIO_EVALUATE= 'evaluate';
    const SCENARIO_STUDENT= 'student';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'certification';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['log_id', 'user_id', 'coach_id', 'score', 'created_at', 'updated_at'], 'integer'],
            [['remarks'], 'string', 'max' => 140],
            [['log_id','user_id','coach_id'],'required','on'=>self::SCENARIO_CERTIFICATE],
            [['score',],'required','on'=>self::SCENARIO_EVALUATE],
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_CERTIFICATE] = ['log_id', 'user_id','coach_id'];
        $scenarios[self::SCENARIO_EVALUATE] = ['score','remarks'];
        $scenarios[self::SCENARIO_STUDENT] = ['user_id'];
        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'log_id' => Yii::t('app', 'diving_log 表id'),
            'user_id' => Yii::t('app', '关联潜水员的id, user表的id，role是潜水员'),
            'coach_id' => Yii::t('app', '关联潜水员的id, user表的id，role是教练'),
            'score' => Yii::t('app', '给教练打分0-5分'),
            'remarks' => Yii::t('app', '对教练的评价'),
            'created_at' => Yii::t('app', '创建时间戳'),
            'updated_at' => Yii::t('app', '更新时间戳'),
        ];
    }

    /**
     * Name: getDivingLog
     * Desc: 认证信息归属的日志
     * Creator: liuzhen<liuzhen12@lenovo.com>
     * CreatedDate: 20170523
     * Modifier:
     * ModifiedDate:
     * @return array|null|\yii\db\ActiveRecord
     */
    public function getDivingLog()
    {
        return $this->hasOne(DivingLog::className(),['id'=>'log_id'])->one();
    }

    /**
     * Name: getDiver
     * Desc: 被认证的潜员
     * Creator: liuzhen<liuzhen12@lenovo.com>
     * CreatedDate: 20170606
     * Modifier:
     * ModifiedDate:
     * @return array|null|\yii\db\ActiveRecord
     */
    public function getDiver()
    {
        return $this->hasOne(User::className(),['id'=>'user_id']);
    }

    /**
     * Name: getCoach
     * Desc: 认证的教练
     * Creator: liuzhen<liuzhen12@lenovo.com>
     * CreatedDate: 20170606
     * Modifier:
     * ModifiedDate:
     * @return array|null|\yii\db\ActiveRecord
     */
    public function getCoach()
    {
        return $this->hasOne(User::className(),['id'=>'coach_id'])->one();
    }
}

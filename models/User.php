<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $open_id
 * @property string $avatar_url
 * @property string $nick_name
 * @property integer $gender
 * @property string $city
 * @property string $province
 * @property string $country
 * @property string $language
 * @property integer $language_detail
 * @property integer $role
 * @property integer $log_count
 * @property integer $equip_count
 * @property string $level_keywords
 * @property integer $speciality_count
 * @property string $title
 * @property integer $is_store_manager
 * @property integer $evaluation_count
 * @property string $evaluation_score
 * @property integer $divestore_id
 * @property integer $created_at
 * @property integer $updated_at
 */
class User extends \app\components\base\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['gender', 'language_detail', 'role', 'log_count', 'equip_count', 'speciality_count', 'is_store_manager', 'evaluation_count', 'divestore_id', 'created_at', 'updated_at'], 'integer'],
            [['evaluation_score'], 'number'],
            [['open_id', 'nick_name', 'city', 'province', 'language', 'level_keywords', 'title'], 'string', 'max' => 45],
            [['avatar_url'], 'string', 'max' => 100],
            [['country'], 'string', 'max' => 2],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'open_id' => Yii::t('app', '微信用户的唯一标识'),
            'avatar_url' => Yii::t('app', '微信头像图片'),
            'nick_name' => Yii::t('app', '微信昵称'),
            'gender' => Yii::t('app', '1:男 2:女'),
            'city' => Yii::t('app', 'City'),
            'province' => Yii::t('app', 'Province'),
            'country' => Yii::t('app', 'Country'),
            'language' => Yii::t('app', 'Language'),
            'language_detail' => Yii::t('app', '1->中 2->英 3->粤'),
            'role' => Yii::t('app', '1->潜员 2->教练'),
            'log_count' => Yii::t('app', '潜员属性->日志数量'),
            'equip_count' => Yii::t('app', '潜员属性->装备数量'),
            'level_keywords' => Yii::t('app', '潜员属性->最新的等级关键词 组织+等级'),
            'speciality_count' => Yii::t('app', '潜员属性->专长数量'),
            'title' => Yii::t('app', '教练属性->职称'),
            'is_store_manager' => Yii::t('app', '教练属性->1->是店长 2->不是店长'),
            'evaluation_count' => Yii::t('app', '教练属性->评价人数'),
            'evaluation_score' => Yii::t('app', '教练属性->评价平均分'),
            'divestore_id' => Yii::t('app', '教练属性->管理的潜店'),
            'created_at' => Yii::t('app', '创建时间戳'),
            'updated_at' => Yii::t('app', '更新时间戳'),
        ];
    }
}

<?php

namespace app\models;

use HttpException;
use Yii;
use yii\base\InvalidValueException;
use yii\base\UserException;
use yii\helpers\Url;
use yii\web\Link;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $open_id
 * @property string $session_key
 * @property string $access_token
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
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class User extends \app\components\base\BaseModel
{
    const SCENARIO_LOGIN = 'login';
    const SCENARIO_DIVER_REGISTER = 'diver';
    const SCENARIO_COACH_REGISTER= 'coach';
    const ROLE = [
        1=>'diver',
        2=>'coach'
    ];

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
            [['gender', 'language_detail', 'role', '!log_count', '!equip_count', '!speciality_count', 'is_store_manager', '!evaluation_count', 'divestore_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['!evaluation_score'], 'number'],
            [['open_id'], 'string', 'max' => 28],
            [['session_key'], 'string', 'max' => 24],
            [['access_token'], 'string', 'max' => 32],
            [['nick_name', 'city', 'province', 'language', '!level_keywords', '!title'], 'string', 'max' => 45],
            [['avatar_url'], 'string', 'max' => 100],
            [['country'], 'string', 'max' => 2],
            [['open_id'], 'unique'],
            [['open_id','session_key','access_token'],'required','on'=>self::SCENARIO_LOGIN],
            [['open_id','session_key','access_token','gender', 'language_detail', 'role',],'required','on'=>self::SCENARIO_DIVER_REGISTER],
            [['open_id','session_key','access_token','gender', 'language_detail', 'role','is_store_manager','divestore_id'],'required','on'=>self::SCENARIO_COACH_REGISTER],
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
            'session_key' => Yii::t('app', '微信用户登录返回'),
            'access_token' => Yii::t('app', '后台根据openid和session_key生成的'),
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
            'status' => Yii::t('app', '1:enable 2:disable'),
            'created_at' => Yii::t('app', '创建时间戳'),
            'updated_at' => Yii::t('app', '更新时间戳'),
        ];
    }

    public function fields()
    {
        $fields = parent::fields();

        // remove fields that contain sensitive information
        unset($fields['open_id'], $fields['session_key']);

        return $fields;
    }

    public function getLinks()
    {
        $links = [Link::REL_SELF => Url::to(['@web/login{?code}'], true)];
        if(in_array(self::getScenario(),[self::SCENARIO_COACH_REGISTER,self::SCENARIO_DIVER_REGISTER])){
            $links['signin'] = Url::to(['@web/sign'], true);
        }
        return $links;
    }

    /**
     * Name: getScenarioByRole
     * Desc: role字段不同，场景不同
     * Creator: liuzhen<liuzhen12@lenovo.com>
     * CreatedDate: 20170523
     * Modifier:
     * ModifiedDate:
     * @param $role
     * @return mixed
     * @throws UserException
     */
    public static function getScenarioByRole($role)
    {
        if(!is_integer($role) || $role > count(static::ROLE,0)){
            throw new HttpException(422,"invalid role");
        }
        return static::ROLE[$role];
    }

    /**
     * Name: incrLogCount
     * Desc:
     * Creator: liuzhen<liuzhen12@lenovo.com>
     * CreatedDate: 20170523
     * Modifier:
     * ModifiedDate:
     */
    public function incrLogCount()
    {
        $this->log_count++;
        if(!$this->save()){
            throw new HttpException(422, implode('|', $this->getFirstErrors()));
        }
    }

    /**
     * Name: decrLogCount
     * Desc:
     * Creator: liuzhen<liuzhen12@lenovo.com>
     * CreatedDate: 20170523
     * Modifier:
     * ModifiedDate:
     */
    public function decrLogCount()
    {
        $this->log_count--;
        if(!$this->save()){
            throw new HttpException(422, implode('|', $this->getFirstErrors()));
        }
    }

}

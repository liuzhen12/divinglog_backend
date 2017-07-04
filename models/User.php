<?php

namespace app\models;

use Yii;
use yii\base\InvalidValueException;
use yii\base\UserException;
use yii\helpers\Url;
use yii\web\HttpException;
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
 * @property string $wechat_no
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
 * @property integer $student_count
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class User extends \app\components\base\BaseModel
{
    const SCENARIO_LOGIN = 'login';
    const SCENARIO_DIVER_REGISTER = 'diver';
    const SCENARIO_COACH_REGISTER= 'coach';
    const SCENARIO_DIVER_INDEX = 'diver_index';
    const SCENARIO_COACH_INDEX= 'coach_index';
    const SCENARIO_DIVER_VIEW = 'diver_view';
    const SCENARIO_COACH_VIEW= 'coach_view';
    const SCENARIO_STUDENT= 'student';
    const ROLE_REGISTER = [
        1=>'diver',
        2=>'coach'
    ];
    const ROLE_INDEX = [
        1=>'diver_index',
        2=>'coach_index'
    ];
    const ROLE_VIEW = [
        1=>'diver_view',
        2=>'coach_view'
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
            [['gender', 'language_detail', 'role', '!log_count', '!equip_count', '!speciality_count', 'is_store_manager', '!evaluation_count', 'divestore_id','!student_count', 'status', 'created_at', 'updated_at'], 'integer'],
            [['!evaluation_score'], 'number'],
            [['open_id'], 'string', 'max' => 28],
            [['session_key'], 'string', 'max' => 24],
            [['access_token'], 'string', 'max' => 32],
            [['nick_name', 'city', 'province', 'language', '!level_keywords', 'title'], 'string', 'max' => 45],
            [['avatar_url'], 'string', 'max' => 200],
            [['country'], 'string', 'max' => 2],
            [['wechat_no'], 'string', 'max' => 20],
            [['open_id'], 'unique'],
            [['open_id','!session_key','!access_token'],'required','on'=>self::SCENARIO_LOGIN],
            [['open_id','session_key','access_token','gender', 'language_detail', 'role'],'required','on'=>self::SCENARIO_DIVER_REGISTER],
            [['open_id','session_key','access_token','gender', 'language_detail', 'role', 'is_store_manager'],'required','on'=>self::SCENARIO_COACH_REGISTER],
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_LOGIN] = ['open_id', 'session_key','access_token'];
        $scenarios[self::SCENARIO_DIVER_REGISTER] = ['open_id','session_key','access_token','gender','avatar_url', 'nick_name', 'country','city', 'province', 'language','language_detail', 'role'];
        $scenarios[self::SCENARIO_COACH_REGISTER] = ['open_id','session_key','access_token','gender','avatar_url',  'nick_name', 'country','city', 'province', 'language','language_detail','wechat_no', 'role','title','is_store_manager','divestore_id','student_count'];
        $scenarios[self::SCENARIO_DIVER_INDEX] = [];
        $scenarios[self::SCENARIO_COACH_INDEX] = ['nick_name','gender','country','province','city','language_detail'];
        $scenarios[self::SCENARIO_DIVER_VIEW] = ['nick_name','gender','country','province','city','language_detail','role','log_count','equip_count','level_keywords','special_count'];
        $scenarios[self::SCENARIO_COACH_VIEW] = ['nick_name','gender','country','province','city','language_detail','wechat_no','role','title','is_store_manager','divestore_id','evaluation_score','student_count'];
        $scenarios[self::SCENARIO_STUDENT] = ['avatar_url', 'nick_name'];
        return $scenarios;
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
            'wechat_no' => Yii::t('app', '微信号或者QQ号或者绑定的手机号，但手机号如果修改，需要重新维护该信息'),
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
            'student_count' => Yii::t('app', '教练属性->学生人数'),
            'status' => Yii::t('app', '1:enable 2:disable'),
            'created_at' => Yii::t('app', '创建时间戳'),
            'updated_at' => Yii::t('app', '更新时间戳'),
        ];
    }

    public function fields()
    {
        $fields = parent::fields();

        // remove fields that contain sensitive information
        unset($fields['open_id'], $fields['session_key'], $fields['status']);

        return $fields;
    }

    public function getLinks()
    {
        $links = [];
        if(in_array(self::getScenario(),[self::SCENARIO_DEFAULT])){
            $links['register'] = Url::to(['@web/register'], true);
            $links['logs'] = Url::to(['@web/diving-logs'], true);
        }
        if(in_array(self::getScenario(),[self::SCENARIO_LOGIN])){
            $links[Link::REL_SELF] = Url::to(['@web/login{?code}'], true);
            $links['me'] = Url::to(["@web/users/{$this->id}"], true);
            $links['logs'] = Url::to(['@web/diving-logs'], true);
        }
        if(in_array(self::getScenario(),[self::SCENARIO_COACH_REGISTER,self::SCENARIO_DIVER_REGISTER])){
            $links[Link::REL_SELF] = Url::to(['@web/register'], true);
            $links['me'] = Url::to(["@web/users/{$this->id}"], true);
        }
        if(in_array(self::getScenario(),[self::SCENARIO_DIVER_INDEX,self::SCENARIO_DIVER_INDEX])){
            $links[Link::REL_SELF] = Url::to(['user/view', 'id' => $this->id], true);
        }
        if(in_array(self::getScenario(),[self::SCENARIO_DIVER_VIEW])){
            $links[Link::REL_SELF] = Url::to(['user/view', 'id' => $this->id], true);
            $links['diving-log'] = Url::to(['@web/diving-logs'], true);
            $links['equip'] = Url::to(['@web/equips'], true);
            $links['level'] = Url::to(['@web/levels'], true);
            $links['default-level'] = Url::to(['@web/diver-levels'], true);
            $links['speciality'] = Url::to(['@web/specialities'], true);
        }
        if(in_array(self::getScenario(),[self::SCENARIO_COACH_VIEW])){
            $links[Link::REL_SELF] = Url::to(['user/view', 'id' => $this->id], true);
            $links['coach-title'] = Url::to(["@web/coach-titles"], true);
            $links['coach-course'] = Url::to(['@web/coach-courses'], true);
            $links['student'] = Url::to(['@web/students'], true);
            $links['divestore'] = Url::to(['@web/divestores/{$this->divestore_id}'], true);
        }
        return $links;
    }

    /**
     * Name: getScenarioByRole4Register
     * Desc: role字段不同，场景不同(注册)
     * Creator: liuzhen<liuzhen12@lenovo.com>
     * CreatedDate: 20170523
     * Modifier:
     * ModifiedDate:
     * @param $role
     * @return mixed
     * @throws UserException
     */
    public static function getScenarioByRole4Register($role)
    {
        $role = intval($role);
        if(!in_array($role,array_keys(static::ROLE_REGISTER))){
            throw new HttpException(422,"invalid role");
        }
        return static::ROLE_REGISTER[$role];
    }

    /**
     * Name: getScenarioByRole4Index
     * Desc: role字段不同，场景不同(概揽)
     * Creator: liuzhen<liuzhen12@lenovo.com>
     * CreatedDate: 20170702
     * Modifier:
     * ModifiedDate:
     * @param $role
     * @return mixed
     * @throws HttpException
     */
    public static function getScenarioByRole4Index($role)
    {
        $role = intval($role);
        if(!in_array($role,array_keys(static::ROLE_INDEX))){
            throw new HttpException(422,"invalid role");
        }
        return static::ROLE_INDEX[$role];
    }

    /**
     * Name: getScenarioByRole4View
     * Desc: role字段不同，场景不同(详情)
     * Creator: liuzhen<liuzhen12@lenovo.com>
     * CreatedDate: 20170702
     * Modifier:
     * ModifiedDate:
     * @param $role
     * @return mixed
     * @throws HttpException
     */
    public static function getScenarioByRole4View($role)
    {
        $role = intval($role);
        if(!in_array($role,array_keys(static::ROLE_VIEW))){
            throw new HttpException(422,"invalid role");
        }
        return static::ROLE_VIEW[$role];
    }

    /**
     * Name: getCertification
     * Desc: 获取教练的认证信息
     * Creator: liuzhen<liuzhen12@lenovo.com>
     * CreatedDate: 20170702
     * ModifiedDate:
     * @return \yii\db\ActiveQuery
     */
    public function getCertification()
    {
        return $this->hasOne(Certification::className(),['id'=>'coach_id']);
    }

    /**
     * Name: incrLogCount
     * Desc: 递增日志数量
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
     * Desc: 递减日志数量
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

    /**
     * Name: incrLogCount
     * Desc: 递增装备数量
     * Creator: liuzhen<liuzhen12@lenovo.com>
     * CreatedDate: 20170523
     * Modifier:
     * ModifiedDate:
     */
    public function incrEquipCount()
    {
        $this->equip_count++;
        if(!$this->save()){
            throw new HttpException(422, implode('|', $this->getFirstErrors()));
        }
    }

    /**
     * Name: decrLogCount
     * Desc: 递减装备数量
     * Creator: liuzhen<liuzhen12@lenovo.com>
     * CreatedDate: 20170523
     * Modifier:
     * ModifiedDate:
     */
    public function decrEquipCount()
    {
        $this->equip_count--;
        if(!$this->save()){
            throw new HttpException(422, implode('|', $this->getFirstErrors()));
        }
    }

    /**
     * Name: updateLevel
     * Desc: 更新等级关键字
     * Creator: liuzhen<liuzhen12@lenovo.com>
     * CreatedDate: 20170606
     * Modifier:
     * ModifiedDate:
     * @param $organization
     * @param $level
     * @throws HttpException
     */
    public function updateLevel($organization,$level)
    {
        $this->level_keywords = $organization . ' ' . $level;
        if(!$this->save()){
            throw new HttpException(422, implode('|', $this->getFirstErrors()));
        }
    }

    /**
     * Name: incrLogCount
     * Desc: 递增装备数量
     * Creator: liuzhen<liuzhen12@lenovo.com>
     * CreatedDate: 20170523
     * Modifier:
     * ModifiedDate:
     */
    public function incrSpecialityCount()
    {
        $this->speciality_count++;
        if(!$this->save()){
            throw new HttpException(422, implode('|', $this->getFirstErrors()));
        }
    }

    /**
     * Name: decrLogCount
     * Desc: 递减装备数量
     * Creator: liuzhen<liuzhen12@lenovo.com>
     * CreatedDate: 20170523
     * Modifier:
     * ModifiedDate:
     */
    public function decrSpecialityCount()
    {
        $this->speciality_count--;
        if(!$this->save()){
            throw new HttpException(422, implode('|', $this->getFirstErrors()));
        }
    }

    /**
     * Name: evaluation
     * Desc: 教练评价,更新对应教练的平均分和评价人数
     * Creator: liuzhen<liuzhen12@lenovo.com>
     * CreatedDate: 20170606
     * Modifier:
     * ModifiedDate:
     * @param $score
     * @throws HttpException
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

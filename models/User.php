<?php

namespace app\models;

use app\components\events\LocationEvent;
use Yii;
use yii\base\Event;
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

    const ROLE = 0;

    const SCENARIO_LOGIN = 'login';
    const SCENARIO_REGISTER = 'register';
    const SCENARIO_INDEX = 'index';
    const SCENARIO_VIEW = 'view';
    const SCENARIO_STUDENT= 'student';

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
            [['gender', 'role', '!log_count', '!equip_count', '!speciality_count', 'is_store_manager', '!evaluation_count', 'divestore_id','!student_count', 'status', 'created_at', 'updated_at'], 'integer'],
            [['!evaluation_score'], 'number'],
            [['open_id'], 'string', 'max' => 28],
            [['session_key'], 'string', 'max' => 24],
            [['access_token'], 'string', 'max' => 32],
            [['nick_name', 'city', 'province', 'language', '!level_keywords', 'title'], 'string', 'max' => 45],
            [['avatar_url'], 'string', 'max' => 200],
            [['country'], 'string', 'max' => 45],
            [['language_detail','wechat_no'], 'string', 'max' => 20],
            [['open_id'], 'unique'],
            [['open_id','!session_key','!access_token'],'required','on'=>self::SCENARIO_LOGIN],
            [['open_id','!session_key','!access_token','gender','avatar_url', 'nick_name', 'country', 'province', 'language','language_detail','role'],'required','on'=>self::SCENARIO_REGISTER]
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_LOGIN] = ['open_id', 'session_key','access_token'];
        $scenarios[self::SCENARIO_REGISTER] = ['open_id','session_key','access_token','gender','avatar_url', 'nick_name', 'country','city', 'province', 'language','language_detail','wechat_no','role'];
        $scenarios[self::SCENARIO_INDEX] = ['avatar_url','nick_name','gender','country','province','city','language','language_detail'];
        $scenarios[self::SCENARIO_VIEW] = ['nick_name','gender','country','province','city','language_detail','wechat_no','role'];
        $scenarios[self::SCENARIO_STUDENT] = ['avatar_url', 'nick_name'];
        return $scenarios;
    }

    public function fields()
    {
        if(in_array(self::getScenario(),[self::SCENARIO_DEFAULT])){
            return parent::fields();
        }
        return ['id','access_token','avatar_url','nick_name','gender','city','province','country','language','language_detail','wechat_no','role'];
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

    public function getLinks()
    {
        $links = [];
        if(in_array(self::getScenario(),[self::SCENARIO_DEFAULT])){
            $links['register'] = Url::to(['@web/register'], true);
            $links['language'] = Url::to(['@web/languages'], true);
            $links['location'] = Url::to(['@web/base-locations{?p_id}'], true);
        }
        if(in_array(self::getScenario(),[self::SCENARIO_LOGIN])){
            $links[Link::REL_SELF] = Url::to(['@web/login{?code}'], true);
            $links['language'] = Url::to(['@web/languages'], true);
            $links['location'] = Url::to(['@web/base-locations{?p_id}'], true);
        }
        if(in_array(self::getScenario(),[self::SCENARIO_REGISTER])){
            $links[Link::REL_SELF] = Url::to(['@web/register'], true);
        }
        return get_class($this) == get_class() ? $links : array_merge($links,$this->getSubInstance()->getLinks());
    }

    /**
     * Name: find
     * Desc: 重写，加入前提条件只筛选特定角色的数据
     * Creator: liuzhen<liuzhen12@lenovo.com>
     * CreatedDate: 20170704
     * Modifier:
     * ModifiedDate:
     * @return $this
     */
    public static function find()
    {
        if(0 === static::ROLE){
            return parent::find();
        }
        return parent::find()->andWhere(['role'=>static::ROLE]);
    }

    /**
     * Name: save
     * Desc:
     * Creator: liuzhen<liuzhen12@lenovo.com>
     * CreatedDate: 20170713
     * Modifier:
     * ModifiedDate:
     * @param bool $runValidation
     * @param null $attributeNames
     * @return bool
     */
    public function save($runValidation = true, $attributeNames = null)
    {
        $doUpdateLanguage = isset($this->getDirtyAttributes()['language_detail']);
        $transaction = Yii::$app->getDb()->beginTransaction();
        try {
            $result = parent::save($runValidation, $attributeNames);
            if ($result && $doUpdateLanguage) {
                foreach($this->userLanguage as $v) {
                    $v->delete();
                }
                foreach (explode(',', $this->language_detail) as $v) {
                    $userLanguage = new UserLanguage();
                    $userLanguage->user_id = $this->id;
                    $userLanguage->language_id = $v;
                    if(!$userLanguage->save()){
                        $transaction->rollBack();
                        return false;
                    }
                }
            }
            $transaction->commit();
            return $result;
        }catch (\Exception $e){
            $transaction->rollBack();
            return false;
        }
    }

    /**
     * Name: getSubClass
     * Desc: 根据后缀确定子类名字
     * Creator: liuzhen<liuzhen12@lenovo.com>
     * CreatedDate: 20170705
     * Modifier:
     * ModifiedDate:
     * @param $role
     * @return stringe
     */
    public function getSubClass($suffix)
    {
        return "app\models\User{$suffix}";
    }

    /**
     * Name: getSubInstance
     * Desc: 实例化一个确定的子类
     * Creator: liuzhen<liuzhen12@lenovo.com>
     * CreatedDate: 20170705
     * Modifier:
     * ModifiedDate:
     * @return mixed
     */
    public function getSubInstance()
    {
        $modelClass = $this->getSubClass($this->role);
        return new $modelClass([
            'scenario' => $this->scenario,
            'id' => $this->id
        ]);
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
        return $this->hasOne(Certification::className(),['coach_id'=>'id']);
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
    public function getUserLanguage()
    {
        return $this->hasMany(UserLanguage::className(),['user_id'=>'id']);
    }
}

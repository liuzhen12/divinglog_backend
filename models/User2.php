<?php
/**
 * Created by PhpStorm.
 * User: liuzhen12
 * Date: 17-7-4
 * Time: 下午5:40
 */

namespace app\models;


use app\components\events\LanguageEvent;
use app\components\events\LocationEvent;
use Yii;
use yii\base\Event;
use yii\helpers\Url;
use yii\web\Link;

class User2 extends User
{

    const ROLE = 2;

    const SCENARIO_REGISTER = 'register';
    const SCENARIO_INDEX = 'index';
    const SCENARIO_VIEW = 'view';

    public function fields()
    {
        $fields = parent::fields();
        $fields['language_detail'] = 'languageDetail';
        if(in_array(self::getScenario(),[self::SCENARIO_DEFAULT])){
            return $fields;
        }
        return array_merge($fields, ['title','is_store_manager','evaluation_count','evaluation_score','student_count','divestore_id','hasDiveStore']);
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_REGISTER] = array_merge($scenarios[self::SCENARIO_REGISTER],['wechat_no','title','is_store_manager']);
        $scenarios[self::SCENARIO_INDEX] = array_merge($scenarios[self::SCENARIO_INDEX],['title','evaluation_count','evaluation_score','student_count']);
        $scenarios[self::SCENARIO_VIEW] = array_merge($scenarios[self::SCENARIO_VIEW],['title','is_store_manager','divestore_id','evaluation_count','evaluation_score','student_count','hasDiveStore']);
        return $scenarios;
    }

    public function getLinks()
    {
        $links = [];
        if(in_array(self::getScenario(),[self::SCENARIO_DEFAULT])){
            $links[Link::REL_SELF] = Url::to(["@web/coaches/{$this->id}"], true);
        }
        if(in_array(self::getScenario(),[self::SCENARIO_LOGIN,self::SCENARIO_REGISTER])){
            $links['me'] = Url::to(["@web/coaches/{$this->id}"], true);
            $links['logs'] = Url::to(['@web/diving-logs'], true);
            $links['activities'] = Url::to(['@web/activity'], true);
            $links['location'] = Url::to(['@web/base-locations{?p_id}'], true);
        }
        if(in_array(self::getScenario(),[self::SCENARIO_INDEX])){
            $links[Link::REL_SELF] = Url::to(['coach/view', 'id' => $this->id], true);
        }
        if(in_array(self::getScenario(),[self::SCENARIO_VIEW])){
            $links[Link::REL_SELF] = Url::to(['coach/view', 'id' => $this->id], true);
            $links['coachTitle'] = Url::to(["@web/coaches/{$this->id}/coach-titles"], true);
            $links['coachCourse'] = Url::to(["@web/coaches/{$this->id}/coach-courses"], true);
            $links['comment'] = Url::to(["@web/coaches/{$this->id}/certifications"], true);
            $links['student'] = Url::to(["@web/coaches/{$this->id}/students"], true);
            $links['divestore'] = Url::to(["@web/divestores". ($this->hasDiveStore ? "/{$this->divestore_id}" : "{?country,province,city}")], true);
        }
        return $links;
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
                $languageData['relation_id'] = $this->getAttribute('id');
                Yii::$app->trigger(LanguageEvent::COACH,new Event(['sender' => $languageData]));
            }
            //触发保存location的事件
            Yii::$app->trigger(LocationEvent::COACH,new Event(['sender' => $locationData]));
        }
        return $result;
    }

    /**
     * Name: delete
     * Desc: 重写，触发保存location的事件
     * Creator: liuzhen<liuzhen12@lenovo.com>
     * CreatedDate: 20170708
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
            Yii::$app->trigger(LanguageEvent::COACH,new Event(['sender' => $languageData]));
            //触发保存location的事件
            Yii::$app->trigger(LocationEvent::COACH,new Event(['sender' => $locationData]));
        }
        return $result;
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
    public function getLanguage()
    {
        return $this->hasMany(Language::className(),['relation_id'=>'id'])->onCondition(['source' => Language::SOURCE_COACH]);
    }

    public function getHasDiveStore()
    {
        return $this->divestore_id > 0;
    }
};
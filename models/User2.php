<?php
/**
 * Created by PhpStorm.
 * User: liuzhen12
 * Date: 17-7-4
 * Time: 下午5:40
 */

namespace app\models;


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
        if(in_array(self::getScenario(),[self::SCENARIO_DEFAULT])){
            return $fields;
        }
        return array_merge($fields, ['title','is_store_manager','evaluation_count','evaluation_score','student_count','divestore_id']);
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_REGISTER] = array_merge($scenarios[self::SCENARIO_REGISTER],['wechat_no','title','is_store_manager']);
        $scenarios[self::SCENARIO_INDEX] = array_merge($scenarios[self::SCENARIO_INDEX],['title','evaluation_count','evaluation_score','student_count']);
        $scenarios[self::SCENARIO_VIEW] = array_merge($scenarios[self::SCENARIO_VIEW],['title','is_store_manager','divestore_id','evaluation_count','evaluation_score','student_count']);
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
            $links['activities'] = Url::to(['@web/activities'], true);
        }
        if(in_array(self::getScenario(),[self::SCENARIO_INDEX])){
            $links[Link::REL_SELF] = Url::to(['coach/view', 'id' => $this->id], true);
        }
        if(in_array(self::getScenario(),[self::SCENARIO_VIEW])){
            $links[Link::REL_SELF] = Url::to(['coach/view', 'id' => $this->id], true);
            $links['coachTitle'] = Url::to(["@web/coaches/{$this->id}/coach-titles"], true);
            $links['coachCourse'] = Url::to(["@web/coaches/{$this->id}/coach-courses"], true);
            $links['student'] = Url::to(["@web/coaches/{$this->id}/students"], true);
            $links['divestore'] = Url::to(["@web/divestores/{$this->divestore_id}"], true);
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
        $data = [];
        $data['country'] = $this->getAttribute('country');
        $data['oldCountry'] = $this->getOldAttribute('country');
        $data['province'] = $this->getAttribute('province');
        $data['oldProvince'] = $this->getOldAttribute('province');
        $data['city'] = $this->getAttribute('city');
        $data['oldCity'] = $this->getOldAttribute('city');
        $result = parent::save($runValidation, $attributeNames);
        if($result){
            //触发保存location的事件
            Yii::$app->trigger(LocationEvent::COACH,new Event(['sender' => $data]));
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
        $data = [];
        $data['oldCountry'] = $this->getAttribute('country');
        $data['oldProvince'] = $this->getAttribute('province');
        $data['oldCity'] = $this->getAttribute('city');
        $result = parent::delete();
        if($result){
            Yii::$app->trigger(LocationEvent::COACH,new Event(['sender' => $data]));
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
};
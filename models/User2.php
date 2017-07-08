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
            $links['coach-title'] = Url::to(["@web/coach-titles"], true);
            $links['coach-course'] = Url::to(['@web/coach-courses'], true);
            $links['student'] = Url::to(['@web/students'], true);
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
        Yii::$app->trigger(LocationEvent::COACH,new Event(['sender' => $data]));
        return $result;
    }
};
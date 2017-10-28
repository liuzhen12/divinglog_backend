<?php
/**
 * Created by PhpStorm.
 * User: liuzhen12
 * Date: 17-7-4
 * Time: 下午5:57
 */

namespace app\models;


use app\components\events\LanguageEvent;
use app\components\events\LocationEvent;
use Yii;
use yii\base\Event;
use yii\helpers\Url;
use yii\web\Link;

class User1 extends User
{

    const ROLE = 1;

    const SCENARIO_REGISTER = 'register';
    const SCENARIO_INDEX = 'index';
    const SCENARIO_VIEW = 'view';


    public function fields()
    {
        $fields = parent::fields();
        if(in_array(self::getScenario(),[self::SCENARIO_DEFAULT])){
            return $fields;
        }
        return array_intersect(array_merge($fields, ['log_count','equip_count','level_keywords','speciality_count']),array_merge(['id'],$this->activeAttributes()));
    }


    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_VIEW] = array_merge($scenarios[self::SCENARIO_VIEW],['log_count','equip_count','level_keywords','speciality_count']);
        return $scenarios;
    }

    public function getLinks()
    {
        $links = [];
        if(in_array(self::getScenario(),[self::SCENARIO_DEFAULT])){
            $links[Link::REL_SELF] = Url::to(["@web/divers/{$this->id}"], true);
        }
        if(in_array(self::getScenario(),[self::SCENARIO_LOGIN,self::SCENARIO_REGISTER])){
            $links['me'] = Url::to(["@web/divers/{$this->id}"], true);
            $links['logs'] = Url::to(['@web/diving-logs'], true);
            $links['activity'] = Url::to(['@web/activities'], true);
            $links['coaches'] = Url::to(['@web/coaches{?country,province,city,gender,language,evaluation_score,student_count}'], true);
            $links['coaches-location'] = Url::to(['@web/locations?source=2'], true);
            $links['divestores'] = Url::to(['@web/divestores'], true);
            $links['divestores-location'] = Url::to(['@web/locations?source=3'], true);
            $links['language'] = Url::to(['@web/base-languages'], true);
        }
        if(in_array(self::getScenario(),[self::SCENARIO_INDEX])){
            $links[Link::REL_SELF] = Url::to(['diver/view', 'id' => $this->id], true);
        }
        if(in_array(self::getScenario(),[self::SCENARIO_VIEW])){
            $links[Link::REL_SELF] = Url::to(['user/view', 'id' => $this->id], true);
            $links['divinglog'] = Url::to(["@web/divers/{$this->id}/diving-logs"], true);
            $links['equip'] = Url::to(['@web/equips'], true);
            $links['level'] = Url::to(['@web/levels'], true);
            $links['default-level'] = Url::to(['@web/diver-levels'], true);
            $links['speciality'] = Url::to(['@web/specialities'], true);
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
        $languageData['relation_id'] = $this->getAttribute('id');
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
                Yii::$app->trigger(LanguageEvent::DIVER,new Event(['sender' => $languageData]));
            }
            //触发保存location的事件
            Yii::$app->trigger(LocationEvent::DIVER,new Event(['sender' => $locationData]));
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
            Yii::$app->trigger(LanguageEvent::DIVER,new Event(['sender' => $languageData]));
            //触发保存location的事件
            Yii::$app->trigger(LocationEvent::DIVER,new Event(['sender' => $locationData]));
        }
        return $result;
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

    /**
     * Name: getCertification
     * Desc: 获取潜员的认证信息
     * Creator: liuzhen<liuzhen12@lenovo.com>
     * CreatedDate: 20170702
     * ModifiedDate:
     * @return \yii\db\ActiveQuery
     */
    public function getCertification()
    {
        return $this->hasOne(Certification::className(),['user_id'=>'id']);
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
        return $this->hasMany(Language::className(),['relation_id'=>'id','source' => Language::SOURCE_DIVER]);
    }
}

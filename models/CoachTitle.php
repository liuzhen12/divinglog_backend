<?php
/**
 * Created by PhpStorm.
 * User: liuzhen12
 * Date: 17-7-4
 * Time: 下午1:45
 */

namespace app\models;
use yii\web\Link;
use yii\helpers\Url;


class CoachTitle extends User
{
    const SCENARIO_TITLE='title';

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_TITLE] = ['title'];
        return $scenarios;
    }

    public function fields()
    {
        return ['id','title'];
    }

    public function getLinks()
    {
        $links = [];
        if(in_array(self::getScenario(),[self::SCENARIO_DEFAULT])){
            $links[Link::REL_SELF] = Url::to(['coach-title/view','id' => $this->id], true);
            $links['edit'] = Url::to(['coach-title/view','id' => $this->id], true);
            $links['index'] = Url::to(['coach-titles'], true);
        }
        if(in_array(self::getScenario(),[self::SCENARIO_TITLE])){
            $links[Link::REL_SELF] = Url::to(['coach-title/view','id' => $this->id], true);
            $links['index'] = Url::to(['@web/coach-titles'], true);
        }
        return $links;
    }
}
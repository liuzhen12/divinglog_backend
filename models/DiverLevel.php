<?php
/**
 * Created by PhpStorm.
 * User: liuzhen12
 * Date: 17-7-4
 * Time: 下午4:30
 */

namespace app\models;


use yii\helpers\Url;
use yii\web\Link;

class DiverLevel extends User
{
    const SCENARIO_LEVEL='level';

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_LEVEL] = ['level_keywords'];
        return $scenarios;
    }

    public function fields()
    {
        return ['id','level_keywords'];
    }

    public function getLinks()
    {
        return [
            Link::REL_SELF => Url::to(['diver-level/view', 'id' => $this->id], true),
            'edit' => Url::to(['diver-level/view', 'id' => $this->id], true),
            'index' => Url::to(['@web/diver-levels'], true)
        ];
    }
}
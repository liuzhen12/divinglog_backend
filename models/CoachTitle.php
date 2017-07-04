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
        return [
            Link::REL_SELF => Url::to(['coach-title/view', 'id' => $this->id], true),
            'edit' => Url::to(['coach-title/view', 'id' => $this->id], true),
            'index' => Url::to(['@web/coach-titles'], true)
        ];
    }
}
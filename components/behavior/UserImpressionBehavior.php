<?php
/**
 * Created by PhpStorm.
 * User: liuzhen12
 * Date: 17-8-25
 * Time: 下午5:06
 */

namespace app\components\behavior;

use Yii;
use yii\base\Behavior;
use app\models\User;

class UserImpressionBehavior extends Behavior
{
    public $supporter;

    public function getUser()
    {
        return  Yii::$app->db->cache(function ($db) {
            return $this->supporter->hasOne(User::className(), ['id' => 'user_id'])->createCommand()->queryOne();
        });
    }

    public function getAvatarUrl()
    {
        return $this->user["avatar_url"];
    }

    public function getNickName()
    {
        return $this->user["nick_name"];
    }

    public function getWechatNo()
    {
        return $this->user["wechat_no"];
    }
}
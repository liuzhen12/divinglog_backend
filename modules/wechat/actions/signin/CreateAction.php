<?php

namespace app\modules\wechat\actions\signin;

use app\models\User;
use yii;

/**
 * Created by PhpStorm.
 * User: liuzhen12
 * Date: 17-5-19
 * Time: 下午2:06
 */
class CreateAction extends \yii\rest\CreateAction
{

    /**
     * Name: run
     * Desc: 在调用主体逻辑之前，对request做转化
     * Creator: liuzhen<liuzhen12@lenovo.com>
     * CreatedDate: 20170523
     * Modifier:
     * ModifiedDate:
     * @return yii\db\ActiveRecordInterface
     */
    public function run()
    {
        $request = Yii::$app->getRequest()->getBodyParams();
        $wechatUser = \app\modules\wechat\helpers\Helper::getIdentification($request["code"]);
        unset($request["code"]);
        $request["open_id"] = $wechatUser->openid;
        $request["session_key"] = $wechatUser->session_key;
        $request["access_token"] = $wechatUser->access_token;
        $this->scenario = User::getScenarioByRole($request["role"]);
        Yii::$app->getRequest()->setBodyParams($request);
        return parent::run();
    }
}
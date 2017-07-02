<?php

namespace app\modules\wechat\actions\login;

use app\models\User;
use yii\rest\Action;
use yii\web\HttpException;

/**
 * Created by PhpStorm.
 * User: liuzhen12
 * Date: 17-5-18
 * Time: 下午3:10
 */
class IndexAction extends Action
{

    public function run($code)
    {
        // step 1: get openid , session key and access token via code
        $wechatUser = \app\modules\wechat\helpers\Helper::getIdentification($code);

        //step 2: 根据openid查找用户，存在则生成access token并返回，不存在则提示注册
        $user = User::findOne(['open_id' => $wechatUser->openid]);

        if(isset($user)){
            $user->scenario = User::SCENARIO_LOGIN;
            //wechat的session key会过期，所以user里的session key过期需要重新保持跟wechat一致，并且access token重新生成
            if($wechatUser->session_key != $user->session_key){
                $user->session_key = $wechatUser->session_key;
                $user->access_token = $wechatUser->access_token;
                if(!$user->save()){
                    throw new HttpException(422, implode('|', $user->getFirstErrors()));
                }
            }
        } else {
            $user = new User();
        }

        return $user;
    }
}
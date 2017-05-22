<?php

namespace app\modules\wechat\actions\login;

use app\helpers\Helper;
use app\models\User;
use yii\base\Exception;
use yii\rest\Action;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use yii\web\HttpException;
use yii\web\Linkable;

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
        // step 1: get openid and session key via code
        $client = new Client();
        try{
            $response = $client->get('https://api.weixin.qq.com/sns/jscode2session',[
                'query'=>[
                    'appid' => 'wx2c2ebb8fdb67118f',
                    'secret' => '74b9a5a0583b62beeab26c7710b9f7db',
                    'js_code' => $code,
                    'grant_type' => 'authorization_code'
                ]
            ]);
            $rawWechatUser = $response->getBody()->getContents();
        } catch (RequestException $e) {
            throw new HttpException(500,$e->getMessage());
        }

        try {
            $wechatUser = \GuzzleHttp\json_decode($rawWechatUser);
        } catch (\InvalidArgumentException $e){
            throw new HttpException(500,$e->getMessage());
        }

        if (!isset($wechatUser->openid)) {
            throw new HttpException(500,"invalid code");
        }
        if (!isset($wechatUser->session_key)) {
            throw new HttpException(500,"invalid code");
        }
        $openid = $wechatUser->openid;
        $sessionKey = $wechatUser->session_key;

        //step 2: 根据openid查找用户，存在则生成access token并返回，不存在则提示注册
        $user = User::findOne(['open_id' => $openid]);

        if(isset($user)){
            //wechat的session key会过期，所以user里的session key过期需要重新保持跟wechat一致，并且access token重新生成
            if($sessionKey != $user->session_key){
                $user->scenario = $user::SCENARIO_LOGIN;
                $user->session_key = $sessionKey;
                $user->access_token = md5(Helper::GetURandom());
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
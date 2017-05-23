<?php
/**
 * Created by PhpStorm.
 * User: liuzhen12
 * Date: 17-5-23
 * Time: 上午11:17
 */

namespace app\modules\wechat\helpers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use yii\web\HttpException;

class Helper
{
    /**
     * Name: getIdentification
     * Desc:
     * Creator: liuzhen<liuzhen12@lenovo.com>
     * CreatedDate: 20170523
     * Modifier:
     * ModifiedDate:
     * @param $code
     */
    public static function getIdentification($code)
    {
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

        $wechatUser->access_token = md5(self::GetURandom());
        return $wechatUser;
    }

    /* *
     * php 版本 >= 5.3， 通过读取"/dev/urandom"实现产生较好随机数
     *
     * */
    public static function GetURandom($min = 0, $max = 0x7FFFFFFF)
    {
        $diff = $max - $min;
        if ($diff > PHP_INT_MAX) {
            throw new RuntimeException('Bad Range');
        }

        $fh = fopen('/dev/urandom', 'r');
        stream_set_read_buffer($fh, PHP_INT_SIZE);
        $bytes = fread($fh, PHP_INT_SIZE );
        if ($bytes === false || strlen($bytes) != PHP_INT_SIZE ) {
            //throw new RuntimeException("nable to get". PHP_INT_SIZE . "bytes");
            return 0;
        }
        fclose($fh);

        if (PHP_INT_SIZE == 8) { // 64-bit versions
            list($higher, $lower) = array_values(unpack('N2', $bytes));
            $value = $higher << 32 | $lower;
        }
        else { // 32-bit versions
            list($value) = array_values(unpack('Nint', $bytes));

        }

        $val = $value & PHP_INT_MAX;
        $fp = (float)$val / PHP_INT_MAX; // convert to [0,1]

        return (int)(round($fp * $diff) + $min);
    }
}
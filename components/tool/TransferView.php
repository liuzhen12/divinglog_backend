<?php
/**
 * Created by PhpStorm.
 * User: liuzhen12
 * Date: 17-7-16
 * Time: 下午5:58
 */

namespace app\components\tool;


use Yii;

class TransferView
{
    public static function transfer($id,$transfer)
    {
        $url = Yii::$app->request->url;
        $url = substr($url,strpos($url,$transfer)-1);
        return Yii::$app->response->redirect($url. (strpos($url,'?') === false ?'?':'&') ."depends_id={$id}&depends_obj=".Yii::$app->controller->id);
    }

    public static function receive()
    {
        return [Yii::$app->request->get('depends_id'),Yii::$app->request->get('depends_obj')];
    }
}
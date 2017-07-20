<?php
/**
 * Created by PhpStorm.
 * User: liuzhen12
 * Date: 17-7-20
 * Time: 下午5:24
 */

namespace app\components\base;


use yii\rest\Serializer;
use yii\web\Link;

class BaseSerializer extends Serializer
{
    public $extraLinksClosure;

    protected function serializeDataProvider($dataProvider)
    {
        $result = parent::serializeDataProvider($dataProvider);
        $links = \Yii::$app->controller->{$this->extraLinksClosure}();
        if(isset($links) && is_array($links)){
            $result["_extra"] = Link::serialize($links);
        }
        return $result;
    }

}
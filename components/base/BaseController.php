<?php
/**
 * Created by PhpStorm.
 * User: liuzhen12
 * Date: 17-5-16
 * Time: 下午6:03
 */

namespace app\components\base;


use yii;
use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;

class BaseController extends ActiveController
{
    public $serializer = [
        'class' => 'app\components\base\BaseSerializer',
        'collectionEnvelope' => 'items',
        'extraLinksClosure' => 'getExtraLinks',
    ];

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::className()
        ];
        return $behaviors;
    }

    public function getExtraLinks()
    {
        return null;
    }
}
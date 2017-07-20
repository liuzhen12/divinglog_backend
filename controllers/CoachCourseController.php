<?php
/**
 * Created by PhpStorm.
 * User: liuzhen12
 * Date: 17-5-16
 * Time: 下午7:42
 */

namespace app\controllers;


use app\components\base\BaseController;
use yii\helpers\Url;
use yii\web\Link;

class CoachCourseController extends BaseController
{
    public $modelClass = 'app\models\CoachCourse';

    public $serializer = [
        'class' => 'app\components\base\BaseSerializer',
        'collectionEnvelope' => 'items',
        'extraLinksClosure' => 'getExtraLinks',
    ];

    public function actions()
    {
        $actions = parent::actions();
        $modelClass = $this->modelClass;
        $actions['index'] = [
            'class' => 'app\components\base\BaseIndexAction',
            'modelClass' => $modelClass,
            'checkAccess' => [$this, 'checkAccess']
        ];
        return $actions;
    }

    public function getExtraLinks()
    {
        return [
            'create' => Url::to(['@web/coach-courses'], true),
            'course' => Url::to(["@web/courses"], true),
        ];
    }

}
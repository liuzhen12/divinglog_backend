<?php
/**
 * Created by PhpStorm.
 * User: liuzhen12
 * Date: 17-5-16
 * Time: 下午7:42
 */

namespace app\controllers;


use app\components\base\BaseController;

class CoachCourseController extends BaseController
{
    public $modelClass = 'app\models\CoachCourse';

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
}
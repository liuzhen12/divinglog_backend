<?php

namespace app\components\traits;

/**
 * Created by PhpStorm.
 * User: liuzhen12
 * Date: 17-6-5
 * Time: 下午12:42
 */
trait ModelFindingTrait
{
    public $modelInstance;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->findModel = function ($id, $action){
            if(isset($action->modelInstance)){
                return $action->modelInstance;
            }

            $modelClass = $action->modelClass;
            $keys = $modelClass::primaryKey();
            if (count($keys) > 1) {
                $values = explode(',', $id);
                if (count($keys) === count($values)) {
                    $model = $modelClass::findOne(array_combine($keys, $values));
                }
            } elseif ($id !== null) {
                $model = $modelClass::findOne($id);
            }

            if (isset($model)) {
                return $action->modelInstance = $model;
            } else {
                throw new NotFoundHttpException("Object not found: $id");
            }
        };
    }
}
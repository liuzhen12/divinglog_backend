<?php
/**
 * Created by PhpStorm.
 * User: liuzhen12
 * Date: 17-6-6
 * Time: 上午11:10
 */

namespace app\actions\certification;


use app\components\traits\ModelFindingTrait;
use Yii;

class UpdateAction extends \yii\rest\UpdateAction
{
    use ModelFindingTrait;

    public function run($id)
    {
        $oldModel = clone $this->findModel($id);
        $model = parent::run($id);

        try{
            //如果有对潜店的打分，则更新对应店铺的平均分和评价人数
            $params = Yii::$app->getRequest()->getBodyParams();
            if(isset($params['score'])){
                $coach = $model->coach;
                if(isset($coach)){
                    $coach->evaluation($params['score']);
                }
            }
        } catch (\Exception $e){
            foreach ($params as $k => $v){
                $oldModel->setOldAttribute($k,$v);
            }
            $oldModel->save();
            throw $e;
        }

        return $model;
    }
}
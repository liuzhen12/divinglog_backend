<?php
/**
 * Created by PhpStorm.
 * User: liuzhen12
 * Date: 17-6-5
 * Time: 下午2:15
 */

namespace app\actions\divingLog;

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
            if(isset($params['divestore_score'])){
                $divestore = $model->divestore;
                if(isset($divestore)){
                    $divestore->evaluation($params['divestore_score']);
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
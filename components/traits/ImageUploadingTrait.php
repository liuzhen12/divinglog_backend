<?php
/**
 * Created by PhpStorm.
 * User: liuzhen12
 * Date: 17-8-12
 * Time: 下午3:19
 */

namespace app\components\traits;


trait ImageUploadingTrait
{

    public function scenarios()
    {
        return
            array_merge(parent::scenarios(),[
                self::SCENARIO_INDEX => ['user_id', 'day','location_longitude','location_latitue','location_name','location_address','assets'],
            ]);
    }
}
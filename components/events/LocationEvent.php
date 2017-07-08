<?php
/**
 * Created by PhpStorm.
 * User: liuzhen12
 * Date: 17-7-7
 * Time: 下午2:28
 */

namespace app\components\events;


use app\models\Location;
use Yii;
use yii\base\BootstrapInterface;
use yii\base\Component;

class LocationEvent extends Component implements BootstrapInterface
{
    CONST DIVER = 'diver';
    CONST COACH = 'coach';
    CONST DIVESTORE = 'divestore';

    public function bootstrap($app)
    {
        Yii::$app->on(self::DIVER, function ($event) {
            (new Location(array_merge($event->sender,['source'=>1])))->batchSave();
        });
        Yii::$app->on(self::COACH, function ($event) {
            (new Location(array_merge($event->sender,['source'=>2])))->batchSave();
        });
        Yii::$app->on(self::DIVESTORE, function ($event) {
            (new Location(array_merge($event->sender,['source'=>3])))->batchSave();
        });
        //Yii::$app->trigger(LocationEvent::DIVER,new Event(['sender' => ['country'=>'China','province'=>'Beijing','city'=>'Changping']]));
    }


}
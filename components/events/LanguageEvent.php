<?php
/**
 * Created by PhpStorm.
 * User: liuzhen12
 * Date: 17-7-31
 * Time: 上午11:12
 */

namespace app\components\events;


use app\models\Language;
use Yii;
use yii\base\BootstrapInterface;
use yii\base\Component;

class LanguageEvent extends Component implements BootstrapInterface
{
    CONST DIVER = 'diver_language';
    CONST COACH = 'coach_language';
    CONST DIVESTORE = 'divestore_language';

    public function bootstrap($app)
    {
        Yii::$app->on(self::DIVER, function ($event) {
            (new Language(array_merge($event->sender,['source'=>1])))->batchSave();
        });
        Yii::$app->on(self::COACH, function ($event) {
            (new Language(array_merge($event->sender,['source'=>2])))->batchSave();
        });
        Yii::$app->on(self::DIVESTORE, function ($event) {
            (new Language(array_merge($event->sender,['source'=>3])))->batchSave();
        });
        //Yii::$app->trigger(LocationEvent::DIVER,new Event(['sender' => ['relation_id'=>1,'language_detail'=>'1,2,3']]));
    }
}

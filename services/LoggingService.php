<?php

namespace app\services;

use yii;
use yii\base\Component;
/**
 * Created by PhpStorm.
 * User: liuzhen12
 * Date: 17-5-16
 * Time: 上午10:36
 */
class LoggingService extends Component implements LoggingInterface
{
    private static $counter = 0;
    private $dynamicCounter = 0;
    private static $id;

    public function getLog()
    {
        return 'hello world';
    }

    public function incr()
    {
        static::$counter += 1;
        return static::$counter;
    }

    public function incrDynamic()
    {
        $this->dynamicCounter += 1;
        return $this->dynamicCounter;
    }

    public function  __construct(array $config = [])
    {
        static::$id = uniqid();
        parent::__construct($config);
    }

    public function __toString()
    {
        return static::$id;
    }
}
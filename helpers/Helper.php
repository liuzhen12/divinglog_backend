<?php

namespace app\helpers;
/**
 * Created by PhpStorm.
 * User: liuzhen12
 * Date: 17-5-19
 * Time: 上午10:34
 */
class Helper
{

    public static function print_stack_trace()
    {
        $ret='';
        $array =debug_backtrace();
        //print_r($array);//信息很齐全
        unset($array[0]);
        foreach($array as $row)
        {
            $ret .=$row['file'].':'.$row['line'].'行,调用方法:'.$row['function']."<p>";
        }
        return $ret;
    }


}
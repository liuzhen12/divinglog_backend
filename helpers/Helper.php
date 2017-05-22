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

    /* *
     * php 版本 >= 5.3， 通过读取"/dev/urandom"实现产生较好随机数
     *
     * */
    public static function GetURandom($min = 0, $max = 0x7FFFFFFF)
    {
        $diff = $max - $min;
        if ($diff > PHP_INT_MAX) {
            throw new RuntimeException('Bad Range');
        }

        $fh = fopen('/dev/urandom', 'r');
        stream_set_read_buffer($fh, PHP_INT_SIZE);
        $bytes = fread($fh, PHP_INT_SIZE );
        if ($bytes === false || strlen($bytes) != PHP_INT_SIZE ) {
            //throw new RuntimeException("nable to get". PHP_INT_SIZE . "bytes");
            return 0;
        }
        fclose($fh);

        if (PHP_INT_SIZE == 8) { // 64-bit versions
            list($higher, $lower) = array_values(unpack('N2', $bytes));
            $value = $higher << 32 | $lower;
        }
        else { // 32-bit versions
            list($value) = array_values(unpack('Nint', $bytes));

        }

        $val = $value & PHP_INT_MAX;
        $fp = (float)$val / PHP_INT_MAX; // convert to [0,1]

        return (int)(round($fp * $diff) + $min);
    }

}
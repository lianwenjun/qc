<?php

/**
 * 工具类
 *
 */
class CUtil
{

    /**
     * 数组转对象
     *
     * @param $array array 待转数组
     *
     * @return object
     */
    public static function array2Object($array)
    {

        return json_decode(json_encode($array), false);
    }

    /**
     * 对象转数组
     *
     * @param $object object 待转对象
     *
     * @return array
     */
    public static function object2Array($object)
    {

        return json_decode(json_encode($object), true);
    }

    /**
     * 友好文件大小
     *
     * @param $size int 文件大小B
     *
     * @return string
     */
    public static function friendlyFilesize($size) {
         
        $mod = 1024;
     
        $units = explode(' ','B KB MB GB TB PB');
        for ($i = 0; $size > $mod; $i++) {
            $size /= $mod;
        }
     
        return round($size, 0) . ' ' . $units[$i];
    }

}
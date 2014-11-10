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
    /*
    * 广告列表的状态判断
    * @param $ad
    * @return string
    */
    public static function adsStatus($ad) {
        $res = '';
        if ($ad->is_stock == 'yes') {
            if (strtotime($ad->unstocked_at) < time()) {
                $res = 'expired';
            } elseif (strtotime($ad->stocked_at) > time()) {
                $res = 'stock';
            } else {
                $res = 'online';
            }
        } else {
            $res = 'unstock';
        }
        return $res;
    }

    //确定是否补全URL
    public static function checkHost($url, $type = 'image') {
        if (empty($url)) return $url;
        if ($type == 'apk') {
            $host = Config::get('app.apkHost');
        } else {
            $host = Config::get('app.imageHost');
        }
        if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
            $url = $host . $url;
        }
        return $url;
    }
    //

    public static function setPageNum($count, $pageSize) {
        $pageSize = intval($pageSize);
        if ($pageSize == 0) {
            return 1;
        }
        $page1 = intval($count) / $pageSize;
        $page2 = intval($count) % $pageSize;
        return $page2 == 0 ? intval($page1) : intval($page1) + 1;
    }
}
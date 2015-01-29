<?php

/**
 * 页面辅助函数
 */
class Helper
{
    /**
     * 页面显示友好文件大小
     * 使用方法
     * Helper::friendlyFilesize(1024) = 1M
     *
     * @param $size int 文件大小KB
     *
     * @return string
     */
    public static function friendlySize($size)
    {
        $size = intval($size);
        $size = $size > 0 ? $size : 0;
        $mod = 1024;
     
        $units = explode(' ','K M G T P');
        for ($i = 0; $size >= $mod; $i++) {
            $size = $size / $mod;
        }
     
        return number_format($size, 1) . '' . $units[$i];
    }
    
    /**
     * 页面时间显示，把Int的时间戳转换成Y-m-d H:i格式
     * 使用方法
     * Helper::date(1420772621) = '2015-01-09 11:03'
     *
     * @param $time int 时间戳
     *
     * @return string
     */
    public static function friendlyDate($time)
    {
        $time = intval($time);
        $time = $time > 0 ? $time : 0;
        $formate = 'Y-m-d H:i';
        
        return date($formate, $time);
    }

    /**
     * 生成分页列表页码
     * 使用方法
     * Helper::pageNum(10, 20, 5) = [8, 9, 10, 11, 12]
     *
     * @param $currentPage int 当前页码
     * @param $totalPage int  总页码
     * @param $showPageNum int 显示页码列表长度
     *
     * @return array
     */
    public static function pageNum($currentPage, $totalPage, $showPageNum = 5)
    {
        if ($totalPage < $showPageNum){
            $showPageNum = $totalPage;
        }
        
        $middle = intval($showPageNum / 2); // 中间页码
        $start = 1; 
        $end = 1;

        if ($currentPage < $showPageNum) { // 小于列表页
            $end = $showPageNum;
        } else if ($currentPage > ($totalPage - $middle)) { // 处于结尾页
            $start = $totalPage - $showPageNum + 1;
            $end = $totalPage;
        } else if ($currentPage <= ($totalPage - $middle)) { // 处理列表页
            $start = $currentPage - $middle;
            $end = $currentPage + $middle;
        }
        return range($start, $end);
    }

    
}
<?php
/**
 * 视图辅助函数
 */
//广告列表的状态判断
if(! function_exists('adsStatus')) {
    function adsStatus($ad) {
        $res = '';
        if ($ad->is_stock == 'yes'){
            if (strtotime($ad->unstocked_at) < time()){
                $res = 'expired';
            }elseif (strtotime($ad->stocked_at) > time()){
                $res = 'stock';
            }else{
                $res = 'online';
            }
        }else{
            $res = 'unstock';
        }
        return $res;
    }
}
?>
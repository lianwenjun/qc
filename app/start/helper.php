<?php
/**
 * 视图辅助函数
 */
//广告列表的状态判断
if(! function_exists('adsStatus')) {
    function adsStatus($ad) {
        $res = '';
        if ($ad->is_onshelf == 'yes'){
            if (strtotime($ad->offshelfed_at) < time()){
                $res = 'expired';
            }elseif (strtotime($ad->onshelfed_at) > time()){
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
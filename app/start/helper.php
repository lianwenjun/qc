<?php
/**
 * 视图辅助函数
 */

function adsStatus($ad) {
    $res = '';
    if ($ad->is_onshelf == 'yes'){
        if (strtotime($ad->offshelfed_at) < time()){
            $res = 'expired';
        }elseif (strtotime($ad->onshelfed_at) > time()){
            $res = 'onshelf';
        }else{
            $res = 'noexpire';
        }
    }else{
        $res = 'offshelf';
    }
    return $res;
}


<?php

class Api_Ratings extends \Eloquent {
    protected $fillable = [];
    protected $table = 'ratings';
    //获取列表数据里的游戏的评分
    public function getAppsRatings($apps) {
        $ids = [];
        foreach ($apps as $app) {
            $ids[] = $app->id;
        }
        if (!$ids) return $apps;
        $ratings = $this->getRatingsByIds($ids);
        foreach ($apps as $app) {
            $app->rating = $ratings[$app->id];
        }
        return $apps;
    }

    public function getRatingsByIds($appIds) {
        $ratings = Api_Ratings::whereIn('app_id', $appIds)->get();
        $tmpIds = [];
        foreach ($appIds as $id) {
            $tmpIds[$id] = 0;
        }
        foreach ($ratings as $rating) {
            $tmpIds[$rating->app_id] = intval($rating->manual);
        }
        return $tmpIds;
    }
}
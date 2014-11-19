<?php

class Api_Comments extends \Eloquent {
    protected $table = 'comments';
    protected $fillable = [];

    //获取列表数据里的游戏的评分
    public function getAppsComments($apps) {
        $ids = [];
        foreach ($apps as $app) {
            $ids[] = $app->id;
        }
        
        $comments = $this->getCommentsByIds($ids);
        foreach ($apps as $app) {
            $app->comment = $comments[$app->id];
        }
        return $apps;
    }

    public function getCommentsByIds($appIds) {
        $appsCount = Api_Comments::select(DB::raw('count(*) as app_count, app_id'))
                     ->whereIn('app_id', $appIds)
                     ->groupBy('app_id')
                     ->get();
        $tmpIds = [];
        foreach ($appIds as $id) {
            $tmpIds[$id] = 0;
        }
        foreach ($appsCount as $app) {
            $tmpIds[$app->app_id] = $app->app_count;
        }
        return $tmpIds;
    }
}
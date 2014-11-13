<?php

class AppDownloads extends \Base
{
    protected $table = 'app_downloads';
    /**
     * 游戏下载统计列表
     *
     * @param $conditions array 查询条件
     * @param $page_size int 单次获取条数
     *
     * @return array 游戏下载统计列表
     */
    public function lists($conditions, $page_size)
    {
        $query = new self;

        if (!empty($conditions)) {
            $type      = $conditions['type'];
            $handwrite = $conditions['handwrite'];
            $choose    = $conditions['choose'];

            $date = $conditions['count_at'];

            if ($type == 'app_id' || $type == 'cat_id') {
                $keyword = $type == 'app_id' ? $handwrite : $choose;
                $query = $query->where($type, $keyword);
            }

            if ($type == 'app_title') {
                $keyword = $handwrite;
                $query = $query->where($type, 'like', $keyword);
            }

            if (!empty($date[0])) {
                $to = empty($date[1]) ? date('Y-m-d H:i:s', strtotime('tomorrow')) : $date[1];
            } else {
                $date[0] = empty($date[1]) ? '' : date('Y-m-d H:i:s', strtotime('today'));
            }

            if (!empty($date[0]) && !empty($date[1])) {
                $query = $query->whereBetween('count_date', $date);
            }
        }

        $list = $query->paginate($page_size)
                      ->toArray();

        return $list;
    }
}
<?php

class AppDownloads extends \Base
{
    protected $table = 'app_downloads';
    protected $guarded = ['id'];

    /**
     * 游戏下载统计列表
     *
     * @param $conditions array 查询条件
     * @param $page_size int 单次获取条数
     *
     * @return array 游戏下载统计列表
     */
    public function lists($conditions)
    {
        $query = new self;

        if (!empty($conditions)) {
            $query = $this->_queryFilter($query, $conditions);
        }

        return $query;
    }

    /**
     * 搜索条件预处理 找出type选中值对应的keyword
     *
     * @param $conditions array 搜索条件数组
     *
     * @return array 处理后的条件数组
     */
    private function _beforeQueryFilter($conditions)
    {
        $format = [];
        $field = '';

        foreach ($conditions as $key => $value) {
            if ($key == 'type' && !empty($value)) {
                $format[$value] = '';
                $field = $value;
            }

            if ($key == 'keyword' && !empty($value) && isset($format[$field])) {
                $format[$field] = $value;
            }

            if ($key == 'cat_id' && !empty($value)) {
                $format[$key] = $value;
            }

            if (
                $key == 'count_at'
                && is_array($value)
                && count($value) == 2
                && !in_array('', $value)
            ) {
                $format[$key] = $value;
            }
        }

        return $format;
    }

    /**
     * 搜索条件过滤
     *
     * @param $query object query对象
     * @param $conditions array 条件数组
     *
     * @return object query对象
     */
    private function _queryFilter($query, $conditions)
    {
        $format = $this->_beforeQueryFilter($conditions);

        foreach ($format as $key => $value) {
            $query = $this->_conditionsParse($key, $value, $query);
        }

        // 排序
        if (isset($conditions['orderby'])) {
            $orderby = explode('.', $conditions['orderby']);
            if (isset($orderby[1]) && !empty($orderby[1])) {
                $query = $query->orderBy($orderby[0], $orderby[1]);
            }
        }

        return $query;
    }

    /**
     * 搜索条件解析处理
     *
     * @param
     *
     * @return array 处理过后的搜索条件数组
     */
    private function _conditionsParse($field, $value, $query)
    {
        switch ($field) {
            case 'app_id':
                $query = $query->where('app_id', $value);
                break;
            case 'cat_id':
                $query = $query->whereRaw("`app_id` in (select `app_id` from `app_cats` where `cat_id`='{$value}')");
                break;
            case 'app_title':
                $query = $query->where('title', 'like', "%{$value}%");
                break;
            case 'count_at':
                $query = $query->whereBetween('count_date', $value);
                break;
            
            default:
                break;
        }

        return $query;
    }

}
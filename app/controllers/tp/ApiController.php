<?php

class Tp_ApiController extends \Tp_BaseController
{
    private $_pageSize = 20;    // 每页最大记录条数
    private $_query    = null;  // query对象
    private $_result   = [];    // query执行结果

    /**
     * 预处理
     */
    public function __construct()
    {
        $this->_checkSign();
    }

    /**
     * 获取游戏信息
     */
    public function getGameInfo()
    {
        $this->_query = Apps::select('title', 'pack', 'stocked_at');

        $this->_dealConditions();
        $this->_execSql();

        $this->retJson(['success' => true, 'data' => $this->_result]);
    }

    /**
     * 进行signKey验证
     */
    private function _checkSign()
    {
        $postKey = Input::get('key');
        $signKey = md5(Request::url() . 'tp-api');

        if (strlen($postKey) == 0 || $postKey != $signKey) {
            $this->retJson(['msg' => 'signkey验证错误']);
        }
    }

    /**
     * 处理搜索条件并对query进行过滤
     */
    private function _dealConditions()
    {
        $hasFilter = false;

        foreach (Input::all() as $key => $value) {
            switch ($key) {
                case 'title':
                case 'package':
                    if (! empty($value)) {
                        $this->_query->where($key, 'like', '%' . $value . '%');
                        $hasFilter = true;
                    }
                    break;

                case 'time':
                    if (is_array($value) &&
                        ! empty($value[0]) &&
                        ! empty($value[1])) {
                        $this->_query->whereBetween('stocked_at', $value);
                        $hasFilter = true;
                    }
                    break;
                
                default:
                    break;
            }
        }

        ! $hasFilter && $this->retJson(['msg' => '搜索条件不能为空']);
    }

    /**
     * 执行query获取搜索结果，并进行分页处理
     */
    private function _execSql()
    {
        $result = $this->_query->orderBy('id', 'desc')
                               ->paginate($this->_pageSize)
                               ->toArray();

        return $this->_result = $result;
    }
}
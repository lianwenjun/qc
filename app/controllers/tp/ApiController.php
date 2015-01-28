<?php

class Tp_ApiController extends Tp_BaseController
{
    private $_key      = 'ea1ebc71';    // 验证串
    private $_pageSize = 50;            // 每页最大记录条数
    private $_query    = null;          // query对象
    private $_result   = [];            // query执行结果

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
        $this->_query = Apps::select('id', 'title', 'pack as package', 'stocked_at');

        $this->_dealConditions();
        $this->_execSql();

        $this->retJson(['success' => true, 'data' => $this->_result]);
    }

    /**
     * 进行signKey验证
     */
    private function _checkSign()
    {
        $postSign = Input::get('sign');
        $sign = md5(Request::url() . $this->_key);

        if (strlen($postSign) == 0 || $postSign != $sign) {
            $this->retJson(['msg' => 'sign验证错误']);
        }
    }

    /**
     * 处理搜索条件并对query进行过滤
     */
    private function _dealConditions()
    {
        foreach (Input::all() as $key => $value) {
            switch ($key) {
                case 'title':
                case 'package':
                    if (! empty($value)) {
                        $this->_query->where($key, 'like', '%' . $value . '%');
                    }
                    break;

                case 'stocked_at':
                    if (is_array($value) && count($value) == 2) {
                        array_walk($value, function(&$value)
                        {
                            $value = date('Y-m-d H:i:s', $value);
                        });
                        $this->_query->whereBetween('stocked_at', $value);
                    }
                    break;
                
                default:
                    break;
            }
        }
    }

    /**
     * 执行query获取搜索结果，并进行分页处理
     */
    private function _execSql()
    {
        $result = $this->_query->paginate($this->_pageSize)->toArray();

        return $this->_result = $result;
    }
}
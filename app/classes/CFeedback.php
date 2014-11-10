<?php

class CFeedback
{
    /**
     * 解析搜索条件
     *
     * @param $query 游戏列表对象
     * @param $data 搜索条件
     *
     * @return $query 游戏列表对象
     **/
    public function queryParse($query, $data)
    {
        if ($data) {
            //关键字处理
            if (isset($data['keyword']) && !empty($data['keyword'])) {
                switch($data['type']) {
                    case 'id':
                        $query->whereId('id', $data['keyword']);
                        break;
                    case 'imei':
                        $query->where('imei', 'like', '%' . $data['keyword'] . '%');
                        break;
                    case 'content':
                        $query->where('content', 'like', '%' . $data['keyword'] . '%');
                        break;
                }
            }

            //时间处理
            if (
                isset($data['created_at'])
                && is_array($data['created_at'])
                && count($data['created_at'])==2
            ) {
                if ($data['created_at'][0] !== '' || $data['created_at'][1] !== '') {
                    if ($data['created_at'][1]) {
                        $data['created_at'][1] = date('Y-m-d', strtotime($data['created_at'][1]) + 24 * 3600);
                    } else {
                        $data['created_at'][1] = date('Y-m-d', time());
                    }
                    $query->whereBetween('created_at', $data['created_at']);
                }
            }
        }

        return $query;
    }

}
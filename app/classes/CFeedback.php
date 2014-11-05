<?php

class CFeedback
{
    /**
     * 解析搜索条件
     *
     * @param $data 搜索条件
     *
     * @return void
     **/
    public function queryParse($query, $data)
    {
        if($data) {
            //关键字处理
            if(isset($data['keyword']) && !empty($data['keyword'])) {
                switch($data['cate']) {
                    case 'id':
                        $query->where('id', $data['keyword']);
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
            if(isset($data['date']) && is_array($data['date']) && count($data['date'])==2) {

                if($data['date'][0] !== '' || $data['date'][1] !== '') {
                    $data['date'][1] = $data['date'][1] ? date('Y-m-d', strtotime($data['date'][1]) + 24 * 3600) : date('Y-m-d', time());
                    $query->whereBetween('created_at', $data['date']);
                }
            }
        }

        return $query;
    }

}
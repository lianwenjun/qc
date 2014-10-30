<?php

class Feedbacks extends \Eloquent {
    protected $fillable = [];
    protected $table = 'feedbacks';
    protected $softDelete = true;

    /**
     * 应用反馈列表
     *
     * @param $data array 条件数据
     *
     * @return obj 反馈列表对象
     **/
    public function lists($data)
    {
        $query = Feedbacks::select('id', 'type', 'imei', 'version', 'email', 'content', 'created_at');

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

                if($data['date'][0] !== '' && $data['date'][1] !== '') {
                    $data['date'][1] = date('Y-m-d', strtotime($data['date'][1]) + 24 * 3600);
                } elseif ($data['date'][0] !== '' && $data['date'][1] == '') {
                    $data['date'][1] = date('Y-m-d', time());
                } elseif ($data['date'][0] == '' && $data['date'][1] !== '') {
                    $data['date'][1] = date('Y-m-d', strtotime($data['date'][1]) + 24 * 3600);
                } elseif ($data['date'][0] == '' && $data['date'][1] == '') {
                    goto outif;
                }

                $query->whereBetween('created_at', $data['date']);
                outif:
            }
        }

        $list = $query->orderBy('created_at')->paginate(5);

        return $list;
    }

}
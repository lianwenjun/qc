<?php

class Groups extends \Eloquent {

    protected $table    = 'groups';
    protected $guarded  = ['id'];

    // 可以搜索字段
    public $searchEnable = [
        'name',
        'department'
    ];

    /**
     * 角色列表
     *
     * @param $data   array 条件数据
     *
     * @return obj 游戏列表对象
     */
    public function lists($data)
    {
        $query = Groups::query();

        return $this->queryParse($query, $data);
    }

    /**
     * 解析条件
     *
     * @param $query obj   query
     * @param $data  array 条件数据
     *
     * @return obj query
     */
    public function queryParse($query, $data)
    {

        foreach($data as $key => $value) {

            if(! in_array($key, $this->searchEnable)) break;

            if($key == 'name' && !empty($value)) {
                $query->where('name', 'like', '%' . $value . '%');
            } elseif (!empty($value)) {
                $query->where($key, $value);
            }
        }

        // 排序
        $query->orderBy('id', 'desc');

        return $query;
    }

    /**
     * 添加角色
     *
     * @param $data array 角色信息
     *
     * @return boolean
     */
    public function store($data)
    {
        if(isset($data['permissions'])) {
            $data['permissions'] = serialize($data['permissions']);
        }

        return Groups::create($data);
    }

    /**
     * 给用户添加角色名
     *
     * @param $users array 用户信息
     * 
     * @return $users array
     */
    public function addGroupName($users)
    {
        foreach($users as $key => $user) {
            $userGroupModel = new UserGroups;
            echo $user['id'];die;
            $ids = $userGroupModel->userGroupIds($user['id']);

            $groups = Groups::whereIn('id', $ids)->get();
            $groupNames = [];
            foreach($groups as $group) {
                $groupNames[] = $group->name;
            }

            $name = '';
            if(!empty($groupNames)) {
                $name = implode(', ', $groupNames);
            }

            echo $users[$key]['group'] = $name;
        }

        return $users;

    }
}
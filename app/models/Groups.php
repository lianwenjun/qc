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

        $data['permissions'] = [];
        if(isset($data['permissions'])) {
            $permissions = [];
            foreach(Input::get('permissions', []) as $permission) {
                $permissions[$permission] = 1;
            }

            $data['permissions'] = $permissions;
        }

        $result = false;
        try {
            Sentry::createGroup($data);
            Session::flash('tips', ['success' => true, 'message' => "亲，角色添加成功了"]);

            $result = true;
        } catch (Cartalyst\Sentry\Groups\NameRequiredException $e) {
            Session::flash('tips', ['success' => false, 'message' => "亲，角色名必填"]);
        } catch (Cartalyst\Sentry\Groups\GroupExistsException $e) {
            Session::flash('tips', ['success' => false, 'message' => "亲，角色名已存在"]);
        }

        return $result;
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
        foreach($users['data'] as $key => $user) {
            $userGroupModel = new UserGroups;
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

            $users['data'][$key]['role'] = $name;
        }

        return $users;
    }
}
<?php

/**
 * User 扩展有用到所以不能改成 Users
 */

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

    use UserTrait, RemindableTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = array('password', 'remember_token');

    // 可以搜索字段
    public $searchEnable = [
        'group_id',
        'activated',
        'username',
    ];

    /**
     * 管理员列表
     *
     * @param $data   array 条件数据
     *
     * @return obj 游戏列表对象
     */
    public function lists($data)
    {
        $query = User::query();

        return $this->queryParse($query, $data);
    }

    /**
    * 根据用户多ID获得用户信息列表
    */
    public function getUserNameByIds($userIds) {
        //获得列表用户数据
        $users = User::whereIn('id', $userIds)->get();
        $userDatas = [0 => 'N/A'];
        foreach ($users as $user) {
            $userDatas[$user->id] = $user->username;
        }
        return $userDatas;
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

            if($key == 'username' && !empty($value)) {
                $query->where('username', 'like', '%' . $value . '%');
            } elseif($key == 'group_id' && !empty($value)) {
                $query->whereRaw("`id` in (select `user_id` from `users_groups` where `group_id` = '{$value}')");
            } elseif (!empty($value) || $value === '0') {
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
     * @return void
     */
    public function store($data)
    {
        try {
            $user = Sentry::createUser(array(
                'email'     => $data['email'],
                'password'  => $data['password'],
                'username'  => $data['username'],
                'realname'  => $data['realname'],
                'activated' => $data['activated'] == '1' ? 1 : 0,
            ));

            $adminGroup = Sentry::findGroupById($data['group_id']);
            $user->addGroup($adminGroup);
            Session::flash('tips', ['success' => true, 'message' => "亲，管理员添加成功"]);
        } catch (Cartalyst\Sentry\Users\LoginRequiredException $e) {
            Session::flash('tips', ['success' => false, 'message' => "亲，用户名必填"]);
        } catch (Cartalyst\Sentry\Users\PasswordRequiredException $e) {
            Session::flash('tips', ['success' => false, 'message' => "亲，密码必填"]);
        } catch (Cartalyst\Sentry\Users\UserExistsException $e) {
            Session::flash('tips', ['success' => false, 'message' => "亲，用户名已存在"]);
        } catch (Cartalyst\Sentry\Groups\GroupNotFoundException $e) {
            Session::flash('tips', ['success' => false, 'message' => "亲，角色不存在"]);
        }
    }

    /**
     * 修改密码
     *
     * @param $id          int    管理员ID
     * @param $newpassword string 新密码
     *
     * @return void
     */
    public function changePwd($id, $newpassword)
    {
        $user = Sentry::findUserById($id);
        $user->attemptResetPassword($user->getResetPasswordCode(), $newpassword);
    }

    /**
     * 添加操作人
     *
     * @param $data array 添加操作人数据
     *
     * @return array
     */
    public function addOperator($data)
    {

        foreach($data['data'] as $k => $item) {
            if(empty($item['operator'])) break;
            $user = Sentry::findUserById($item['operator']);
            $data['data'][$k]['operator'] = $user->username;
        }

        return $data;
    }

    public function getUserNameByList($key = [],$list = []) {
        $userIds = [0];
        foreach ($list as $l) {
            foreach ($key as $k) {
                if (!isset($userIds[$l->$k])){
                    $userIds[] = $l->$k;
                }
            }
        }
        //能否整合进$list里呢？
        $users = User::whereIn('id', $userIds)->get();
        $userDatas = [0 => '系统'];
        foreach ($users as $user) {
            $userDatas[$user->id] = $user->username;
        }
        return $userDatas;
    }

}
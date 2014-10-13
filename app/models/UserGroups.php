<?php

class UserGroups extends \Eloquent {

    protected $table      = 'users_groups';
    protected $dates      = ['deleted_at'];
    protected $guarded    = ['id'];

    /**
     * 获取用户所属组IDs
     *
     * @param $userId int 用户ID
     *
     * @return array [0 => int, 1 => int]
     */
    public function userGroupIds($userId) {

        $userGroups = UserGroups::where('user_id', $userId)->get();

        $ids = [];
        foreach($userGroups as $userGroup) {
            $ids[] = $userGroup->group_id;
        }

        return $ids;
    }

}
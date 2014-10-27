<?php
/*
*后台管理用户方法
*/
class Admin_CuserClass {
    /*
    * 根据字段获取本列表内的用户名
    * @param key array
    * @param list array
    * @return data array
    */
    public function getUserNameByList($key = [],$list = []) {
        $userIds = [0];
        function cube($n)
        {
            return($n * $n * $n);
        }
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
?>
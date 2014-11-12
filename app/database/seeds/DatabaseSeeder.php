<?php

class DatabaseSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Eloquent::unguard();

        $this->call('UserTableSeeder');
    }

}
class UserTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // admin
        $user = Sentry::register([
            'username'  =>  'admin',
            'password'  => 'bili.bili',
            'realname'  =>  '管理员',
            'email'     => 'admin@ltbl.cn',
            'activated' => 1
        ]);

        // group
        $group = Sentry::createGroup([
            'name'        => '管理员',
            'permissions' => [
                'users.index' => 1,
                'users.create' => 1,
                'users.edit' => 1,
                'users.delete' => 1,
                'roles.index' => 1,
                'roles.create' => 1,
                'roles.edit' => 1,
                'roles.delete' => 1
            ],
            'department' => 1
        ]);

        // add to group
        $user->addGroup($group);
        
    }

}

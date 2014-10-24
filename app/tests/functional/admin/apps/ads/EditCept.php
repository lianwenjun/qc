<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('首页游戏广告位编辑');

//先登录
$data = ['username' => 'test', 'password' => 'test'];
$I->sendAjaxRequest('PUT', '/admin/users/signin', $data);

$I->amOnPage('/admin/appsads/4/edit');
$fields = [
            'location' => 'hotdown',
            'images' => 'xxxoooo',
            'is_top' => 'yes',
            'stocked_at' => '2014-10-10 10:10:10',
            'unstocked_at' => '1411720308',
            ];
$I->sendAjaxPostRequest('/admin/appsads/4/edit', $fields);
$I->seeSessionHasValues(['msg' => '修改成功']);
<?php
/*
测试角色场景

删除游戏君: 只能被人删除使用 ID 444

未知删除君: 让人琢磨不透的 ID 888888， 不存在数据库中

*/
$I = new FunctionalTester($scenario);
$I->wantTo('添加编辑游戏删除功能');

// 登陆
$data = ['username' => 'test', 'password' => 'test'];
$I->sendAjaxRequest('PUT', '/admin/users/signin', $data);

$I->amOnPage('/admin/apps/draft');

// 正常删除
$I->seeRecord('apps', ['id' => '444', 'status' => 'publish', 'deleted_at' => null]);
$I->sendAjaxRequest('DELETE', '/admin/apps/444');
$I->dontSeeRecord('apps', ['id' => '444', 'deleted_at' => null]);


// 删除不存在的
$I->dontSeeRecord('apps', ['id' => '888888', 'deleted_at' => null]);
$I->sendAjaxRequest('DELETE', '/admin/apps/888888');
$I->seeInSession(['tips'=>['success' => false, 'message' => '亲，ID：888888不存在']]);
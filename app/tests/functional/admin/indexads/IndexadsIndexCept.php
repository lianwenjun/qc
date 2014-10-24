<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('首页图片位列表页');
//先登录
$data = ['username' => 'test', 'password' => 'test'];
$I->sendAjaxRequest('PUT', '/admin/users/signin', $data);

$I->amOnPage('/admin/indexads/index');
$I->see('首页图片位管理');
$I->click("添加游戏");
$I->see('搜索');

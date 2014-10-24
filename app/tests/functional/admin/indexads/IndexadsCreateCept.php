<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('首页图片位添加页面');
//先登录
$data = ['username' => 'test', 'password' => 'test'];
$I->sendAjaxRequest('PUT', '/admin/users/signin', $data);

$I->amOnPage('/admin/indexads/create');
$I->see('添加游戏');
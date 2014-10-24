<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('游戏评分界面');
//先登录
$data = ['username' => 'test', 'password' => 'test'];
$I->sendAjaxRequest('PUT', '/admin/users/signin', $data);

$I->amOnPage('/admin/rating/index');
$I->see('游戏评分列表');

$I->see('删除游戏A君');
<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('审核不通过游戏列表');
//先登录
$data = ['username' => 'test', 'password' => 'test'];
$I->sendAjaxRequest('PUT', '/admin/users/signin', $data);

$I->amOnAction('Admin_Apps_IndexController@notpass');
$I->see('不通过游戏A君');

// 由于功能类似不重复测试
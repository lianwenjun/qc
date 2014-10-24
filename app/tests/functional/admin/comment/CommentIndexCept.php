<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('游戏评论列表测试');
//先登录
$data = ['username' => 'test', 'password' => 'test'];
$I->sendAjaxRequest('PUT', '/admin/users/signin', $data);

$I->amOnPage('/admin/comment/index');
$I->see('游戏评论列表');

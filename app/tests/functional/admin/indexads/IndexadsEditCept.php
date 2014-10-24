<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('首页图片位编辑页面');
//先登录
$data = ['username' => 'test', 'password' => 'test'];
$I->sendAjaxRequest('PUT', '/admin/users/signin', $data);

$I->amOnPage('/admin/indexads/18/edit');
$I->see('编辑游戏');

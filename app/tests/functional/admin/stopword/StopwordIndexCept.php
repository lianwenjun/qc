<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('屏蔽词列表页面测试');
//先登录
$data = ['username' => 'test', 'password' => 'test'];
$I->sendAjaxRequest('PUT', '/admin/users/signin', $data);

$I->amOnPage('/admin/stopword/index');
$I->see('屏蔽词管理');

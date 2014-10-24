<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('游戏排行广告位列表');
//先登录
$data = ['username' => 'test', 'password' => 'test'];
$I->sendAjaxRequest('PUT', '/admin/users/signin', $data);

$I->amOnpage('/admin/rankads/index');
$I->see('排行游戏位管理');
$I->see('最新');
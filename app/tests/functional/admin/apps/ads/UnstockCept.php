<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('广告游戏位下架');
//先登录
$data = ['username' => 'test', 'password' => 'test'];
$I->sendAjaxRequest('PUT', '/admin/users/signin', $data);

//存在测试
$I->amOnRoute('appsads.unstock', 0);
$I->amOnAction('Admin_Apps_AppsAdsController@index', 0);

$I->amOnPage('/admin/appsads/1/unstock');
$I->seeSessionHasValues(['msg' => '亲，#1下架成功']);
//不存在测试
$I->amOnPage('/admin/appsads/2/unstock');
$I->seeSessionHasValues(['msg' => '亲，#2下架失败了']);

$I->amOnPage('/admin/appsads/0/unstock');
$I->seeSessionHasValues(['msg' => '亲，#0下架失败了']);


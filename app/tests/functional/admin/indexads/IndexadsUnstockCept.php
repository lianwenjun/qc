<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('首页图片位管理下架');
//先登录
$data = ['username' => 'test', 'password' => 'test'];
$I->sendAjaxRequest('PUT', '/admin/users/signin', $data);

//存在测试
$I->amOnPage('/admin/indexads/28/unstock');
$I->seeSessionHasValues(['msg' => '亲，#28下架成功']);
//不存在测试
$I->amOnPage('/admin/indexads/1/unstock');
$I->seeSessionHasValues(['msg' => '亲，#1不存在']);

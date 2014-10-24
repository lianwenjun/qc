<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('分类页面');
//先登录
$data = ['username' => 'test', 'password' => 'test'];
$I->sendAjaxRequest('PUT', '/admin/users/signin', $data);

$I->amOnPage('admin/cat/index');
//检测ACTION和ROUTENAME
$I->seeCurrentRouteIs('cat.index');
$I->seeCurrentActionIs('Admin_Cat_CatsController@index');
$I->see('分类标签管理');
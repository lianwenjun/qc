<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('游戏标签列表页');
//先登录
$data = ['username' => 'test', 'password' => 'test'];
$I->sendAjaxRequest('PUT', '/admin/users/signin', $data);

$I->amOnPage('admin/tag/index');
//检测ACTION和ROUTENAME
$I->seeCurrentRouteIs('tag.index');
$I->seeCurrentActionIs('Admin_Cat_CatsController@tagIndex');
$I->see('游戏标签管理');

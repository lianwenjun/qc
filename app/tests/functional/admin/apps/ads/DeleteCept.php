<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('首页游戏广告位删除');

//先登录
$data = ['username' => 'test', 'password' => 'test'];
$I->sendAjaxRequest('PUT', '/admin/users/signin', $data);

//存在测试
$I->sendAjaxRequest('DELETE', '/admin/appsads/1/delete');
$I->seeSessionHasValues(['msg' => '#1删除成功']);
//不存在测试
$I->sendAjaxRequest('DELETE', '/admin/appsads/120/delete');
$I->seeSessionHasValues(['msg' => '#120删除失败']);
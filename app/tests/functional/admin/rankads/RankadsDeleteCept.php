<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('游戏排行广告删除');
//先登录
$data = ['username' => 'test', 'password' => 'test'];
$I->sendAjaxRequest('PUT', '/admin/users/signin', $data);

//存在测试
$I->sendAjaxRequest('DELETE' ,'/admin/rankads/49/delete');
$I->seeSessionHasValues(['msg' => '#49删除成功']);
//不存在测试
$I->sendAjaxRequest('DELETE' ,'/admin/rankads/1/delete');
$I->seeSessionHasValues(['msg' => '#1不存在']);
$I->sendAjaxRequest('DELETE' ,'/admin/rankads/100/delete');
$I->seeSessionHasValues(['msg' => '#100不存在']);
$I->sendAjaxRequest('DELETE' ,'/admin/rankads/13/delete');
$I->seeSessionHasValues(['msg' => '#13不存在']);
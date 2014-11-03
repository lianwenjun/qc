<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('首页图片位管理删除');
//先登录
$data = ['username' => 'test', 'password' => 'test'];
$I->sendAjaxRequest('PUT', '/admin/users/signin', $data);

//存在测试
$I->sendAjaxRequest('DELETE' ,'/admin/indexads/28/delete');
$I->seeSessionHasValues(['msg' => '#28删除成功']);
//不存在测试
$I->sendAjaxRequest('DELETE' ,'/admin/indexads/1/delete');
$I->seeSessionHasValues(['msg' => '#1不存在']);

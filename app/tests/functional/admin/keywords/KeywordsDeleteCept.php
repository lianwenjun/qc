<?php
/*
* 删除关键字列表测试
*/ 
$I = new FunctionalTester($scenario);
$I->wantTo('关键词删除功能');
//先登录
$data = ['username' => 'test', 'password' => 'test'];
$I->sendAjaxRequest('PUT', '/admin/users/signin', $data);

//存在测试
$I->sendAjaxRequest('DELETE' ,'/admin/keyword/1/delete');
$I->seeSessionHasValues(['msg' => '#1删除成功']);
//不存在测试
$I->sendAjaxRequest('DELETE' ,'/admin/keyword/2/delete');
$I->seeSessionHasValues(['msg' => '#2不存在']);
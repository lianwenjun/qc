<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('删除编辑精选广告');
//先登录
$data = ['username' => 'test', 'password' => 'test'];
$I->sendAjaxRequest('PUT', '/admin/users/signin', $data);

//存在测试
$I->sendAjaxRequest('DELETE' ,'/admin/editorads/36/delete');
$I->seeSessionHasValues(['msg' => '#36删除成功']);

//不存在测试
$I->sendAjaxRequest('DELETE' ,'/admin/editorads/20/delete');
$I->seeSessionHasValues(['msg' => '#20不存在']);

//保存失败测试


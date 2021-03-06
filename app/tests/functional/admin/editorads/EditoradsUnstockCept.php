<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('下架编辑精选广告');
//先登录
$data = ['username' => 'test', 'password' => 'test'];
$I->sendAjaxRequest('PUT', '/admin/users/signin', $data);

//存在测试
$I->amOnpage('/admin/editorads/36/unstock');
$I->seeSessionHasValues(['msg' => '亲，#36下架成功']);

//不存在测试
$I->amOnpage('/admin/editorads/20/unstock');
$I->seeSessionHasValues(['msg' => '亲，#20不存在']);

$I->amOnpage('/admin/editorads/27/unstock');
$I->seeSessionHasValues(['msg' => '亲，#27不存在']);
//保存失败测试


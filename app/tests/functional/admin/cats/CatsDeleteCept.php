<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('分类/标签删除');
//先登录
$data = ['username' => 'test', 'password' => 'test'];
$I->sendAjaxRequest('PUT', '/admin/users/signin', $data);

//标签测试
$I->sendAjaxRequest('DELETE', '/admin/tag/3/delete');
//$I->seeSessionHasValues(['msg' => '#1删除成功']);
$I->seeSessionHasValues(['msg' => 'suss delete']);
//不存在测试
$I->sendAjaxRequest('DELETE', '/admin/tag/20/delete');
//$I->seeSessionHasValues(['msg' => '#2不存在']);
$I->seeSessionHasValues(['msg' => 'error,tag #20 is valid']);

//分类测试
$I->amOnpage('/admin/cat/2/delete');
//$I->seeSessionHasValues(['msg' => '#1删除成功']);
$I->see('ok');
//不存在测试
$I->amOnpage('/admin/cat/3/delete');
//$I->seeSessionHasValues(['msg' => '#2不存在']);
$I->see('error');




<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('获得分类的详细标签列表');
//先登录
$data = ['username' => 'test', 'password' => 'test'];
$I->sendAjaxRequest('PUT', '/admin/users/signin', $data);

//存在检测
$I->sendAjaxGetRequest('/admin/cat/1'); // GET
$I->see('ok');
//不存在检测

$I->sendAjaxGetRequest('/admin/cat/150'); // GET
$I->see('error');
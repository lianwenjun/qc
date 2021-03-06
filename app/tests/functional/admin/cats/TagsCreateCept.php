<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('添加标签');
//先登录
$data = ['username' => 'test', 'password' => 'test'];
$I->sendAjaxRequest('PUT', '/admin/users/signin', $data);

//正确测试
$I->sendAjaxPostRequest('/admin/tag/create', ['word' => '我是来打酱油的', 'parent_id'=>'1']); // POST
$I->see('suss');
$I->sendAjaxPostRequest('/admin/tag/create', ['word' => '12345678901234567890', 'parent_id' => '1']);
$I->see('suss');
//错误的
$I->sendAjaxPostRequest('/admin/tag/create', ['word1' => '我是来打酱油的']); // POST
$I->see('error');
$I->sendAjaxPostRequest('/admin/tag/create', ['word1' => '我是来打酱油的', 'parent_id' => '1']); // POST
$I->see('error');
$I->sendAjaxPostRequest('/admin/tag/create', ['word' => '']); // POST
$I->see('error');
$I->sendAjaxPostRequest('/admin/tag/create', ['word' => '我是来打酱油的', 'parent_id' => '']); // POST
$I->see('error');
$I->sendAjaxPostRequest('/admin/tag/create', ['word' => '', 'parent_id' => '']); // POST
$I->see('error');
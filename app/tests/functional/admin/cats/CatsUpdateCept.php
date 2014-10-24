<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('修改更新分类项');
//先登录
$data = ['username' => 'test', 'password' => 'test'];
$I->sendAjaxRequest('PUT', '/admin/users/signin', $data);

//正确测试
$I->sendAjaxPostRequest('/admin/cat/1/edit', ['word' => '我是来打酱油的']); // POST
$I->see('suss');
$I->sendAjaxPostRequest('/admin/cat/3/edit', ['word' => '12345678901234567890']);
$I->see('suss');

//错误的
$I->sendAjaxPostRequest('/admin/cat/1/edit', ['word1' => '我是来打酱油的']); // POST
$I->see('error');
$I->sendAjaxPostRequest('/admin/cat/3/edit', ['word' => '']); // POST
$I->see('error');


<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('更新分类广告的数据');
//先登录
$data = ['username' => 'test', 'password' => 'test'];
$I->sendAjaxRequest('PUT', '/admin/users/signin', $data);

$I->sendAjaxPostRequest('/admin/catads/2/edit', ['image' => 'xxxxx2222222.jpg']);
$I->see('ok');

$I->sendAjaxPostRequest('/admin/catads/111/edit', ['image' => 'xxxxx2222222.jpg']);
$I->see('valid');

$I->sendAjaxPostRequest('/admin/catads/3/edit', ['image1' => 'xxxxx2222222.jpg']);
$I->see('error');
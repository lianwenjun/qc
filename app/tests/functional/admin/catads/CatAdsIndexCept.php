<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('分类页图片位推广列表');
//先登录
$data = ['username' => 'test', 'password' => 'test'];
$I->sendAjaxRequest('PUT', '/admin/users/signin', $data);

$I->amOnPage('/admin/catads/index');
$I->see('分类页图片位推广');
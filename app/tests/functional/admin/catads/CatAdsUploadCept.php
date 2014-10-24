<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('分类图片上传');
//先登录
$data = ['username' => 'test', 'password' => 'test'];
$I->sendAjaxRequest('PUT', '/admin/users/signin', $data);
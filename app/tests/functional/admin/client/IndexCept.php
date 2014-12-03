<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('本地APP版本列表');
$data = ['username' => 'test', 'password' => 'test'];
$I->sendAjaxRequest('PUT', '/admin/users/signin', $data);
$URL = '/admin/client/index';
$I->amOnPage($URL);
$I->see('天天游戏中心');
//$I->see('添加新版本');
//$I->see('编辑');

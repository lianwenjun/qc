<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('本地APP版本添加');
$URL = '/admin/client/edit/1';
$data = ['username' => 'test', 'password' => 'test'];
$I->sendAjaxRequest('PUT', '/admin/users/signin', $data);
$I->amOnPage($URL);
$I->see('编辑');
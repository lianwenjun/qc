<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('本地APP版本添加');
$URL = '/admin/client/create';
$data = ['username' => 'test', 'password' => 'test'];
$I->sendAjaxRequest('PUT', '/admin/users/signin', $data);
$I->amOnPage($URL);
$I->see('添加');

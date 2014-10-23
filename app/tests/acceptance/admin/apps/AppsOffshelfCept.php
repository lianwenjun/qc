<?php 
$I = new AcceptanceTester($scenario);
$I->wantTo('下架游戏列表');

// 登陆
$I->amOnPage('/admin/users/signin');
$I->fillField('username', 'test');
$I->fillField('password', 'test');
$I->click(['class' => 'login_submit']);

$I->amOnPage('/admin/apps/offshelf');
$I->see('下架游戏');


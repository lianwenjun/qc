<?php 
$I = new AcceptanceTester($scenario);
$I->wantTo('审核不通过列表');

// 登陆
$I->amOnPage('/admin/users/signin');
$I->fillField('username', 'test');
$I->fillField('password', 'test');
$I->click(['class' => 'login_submit']);

$I->amOnPage('/admin/apps/notpass');
$I->see('审核不通过游戏');

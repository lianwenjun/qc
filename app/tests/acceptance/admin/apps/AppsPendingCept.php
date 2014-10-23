<?php 
$I = new AcceptanceTester($scenario);
$I->wantTo('待审核列表');

// 登陆
$I->amOnPage('/admin/users/signin');
$I->fillField('username', 'test');
$I->fillField('password', 'test');
$I->click(['class' => 'login_submit']);

$I->amOnPage('/admin/apps/pending');
$I->see('待审核游戏');

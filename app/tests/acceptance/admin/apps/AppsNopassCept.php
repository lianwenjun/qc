<?php 
$I = new AcceptanceTester($scenario);
$I->wantTo('审核不通过列表');

$I->amOnPage('/admin/users/signin');
$I->fillField('username', 'test');
$I->fillField('password', 'test');
$I->click(['class' => 'login_submit']);

$I->amOnPage('/admin/apps/nopass');
$I->see('审核不通过游戏');

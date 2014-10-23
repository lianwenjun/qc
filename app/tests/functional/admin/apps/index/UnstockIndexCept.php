<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('下架游戏列表功能');

$I->amOnAction('Admin_Apps_IndexController@unstock');
$I->see('下架游戏A君');

// 由于功能类似不重复测试
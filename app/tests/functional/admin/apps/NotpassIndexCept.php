<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('审核不通过游戏列表');

$I->amOnAction('Admin_Apps_IndexController@nopass');
$I->see('不通过游戏A君');

// 由于功能类似不重复测试
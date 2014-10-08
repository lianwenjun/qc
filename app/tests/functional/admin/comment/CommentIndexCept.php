<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('游戏评论列表测试');
$I->amOnPage('/admin/comment/index');
$I->see('游戏评论列表');
$I->click('删除');
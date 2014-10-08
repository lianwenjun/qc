<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('首页图片位添加页面');
$I->amOnPage('/admin/indexads/create');
$I->see('添加游戏');
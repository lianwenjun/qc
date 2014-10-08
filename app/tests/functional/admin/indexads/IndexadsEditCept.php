<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('首页图片位编辑页面');
$I->amOnPage('/admin/indexads/18/edit');
$I->see('编辑游戏');

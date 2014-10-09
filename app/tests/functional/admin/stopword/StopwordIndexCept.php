<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('屏蔽词列表页面测试');
$I->amOnPage('/admin/stopword/index');
$I->see('屏蔽词管理');

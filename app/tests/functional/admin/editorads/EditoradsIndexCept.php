<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('编辑精选广告页面');
//正常测试
$I->amOnpage('/admin/editorads/index');
$I->see('编辑精选管理');
$I->click('添加游戏');
$I->seeNumberOfElements('tr', [1, 10]);
//搜索测试
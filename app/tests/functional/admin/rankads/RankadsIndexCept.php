<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('游戏排行广告位列表');
$I->amOnpage('/admin/rankads/index');
$I->see('排行游戏位管理');
$I->see('最新');
$I->see('是否置顶');
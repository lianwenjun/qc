<?php 
$I = new AcceptanceTester($scenario);
$I->wantTo('添加编辑游戏');
$I->amOnPage('/admin/apps/onshelf');
$I->see('上架游戏');

<?php 
$I = new AcceptanceTester($scenario);
$I->wantTo('添加编辑游戏');
$I->amOnPage('/admin/apps/index');
$I->see('待编辑游戏');
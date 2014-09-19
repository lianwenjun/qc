<?php 
$I = new AcceptanceTester($scenario);
$I->wantTo('添加编辑游戏(草稿)');
$I->amOnPage('/admin/apps/draft');
$I->see('待编辑游戏');
<?php 
$I = new AcceptanceTester($scenario);
$I->wantTo('待审核列表');
$I->amOnPage('/admin/apps/pending');
$I->see('待审核游戏');

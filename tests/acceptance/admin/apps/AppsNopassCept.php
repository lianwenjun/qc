<?php 
$I = new AcceptanceTester($scenario);
$I->wantTo('审核不通过列表');
$I->amOnPage('/admin/apps/nopass');
$I->see('待审核游戏');

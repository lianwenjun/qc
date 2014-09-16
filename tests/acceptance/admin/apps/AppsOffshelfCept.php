<?php 
$I = new AcceptanceTester($scenario);
$I->wantTo('下架游戏列表');
$I->amOnPage('/admin/apps/offshelf');
$I->see('下架游戏');


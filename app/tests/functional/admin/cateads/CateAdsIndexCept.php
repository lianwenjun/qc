<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('分类页图片位推广列表');
$I->amOnPage('/admin/cateads/index');
$I->see('分类页图片位推广');
<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('获取所有的分类的名称以及ID');
$URL = '/api/v1/game/category/all';
$I->amOnPage($URL);
$I->see('dataJson');
$I->see('ImgUrl');
$I->see('"msg":"1"');
<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('游戏搜索信息');
//按作者搜索
$URL = '/api/game/search/1/波音公司/1/10/1';
$I->amOnPage($URL);
$I->see('"msg":1');
//按分类搜索
$URL = '/api/game/search/2/1/1/10/1';
$I->amOnPage($URL);
$I->see('"msg":1');
//直接输入
$URL = '/api/game/search/3/游戏/1/10/1';
$I->amOnPage($URL);
$I->see('"msg":1');
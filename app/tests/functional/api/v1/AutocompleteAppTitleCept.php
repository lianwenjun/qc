<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('自动补全搜索游戏名');
$URL = '/v1/api/game/search/autocomplete/a';
$I->amOnPage($URL);
$I->see('dataJson');
$I->see('100');
$I->see('"msg":1');
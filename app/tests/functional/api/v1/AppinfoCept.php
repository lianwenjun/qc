<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('获得单个游戏的信息');
$URL = '/api/game/info/appid/100';
$I->amOnPage($URL);
$I->see('"msg":1');


$URL = '/api/game/info/appid/1000';
$I->amOnPage($URL);
$I->see('"msg":0');

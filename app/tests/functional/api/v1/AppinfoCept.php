<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('获得单个游戏的信息');
$URL = '/v1/game/info/appid/1';
$I->amOnPage($URL);
$I->see('"msg":1');


$URL = '/v1/game/info/appid/1000';
$I->amOnPage($URL);
$I->see('"msg":0');

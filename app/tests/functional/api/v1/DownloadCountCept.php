<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('下载游戏统计');
$appid = '100';
$imei = '44a0dfuasdfasdfasdf';
$URL = '/api/game/info/edit/downcount/'.$appid.'/'.$imei;
$I->sendAjaxGetRequest($URL);
$I->see('"msg":1');

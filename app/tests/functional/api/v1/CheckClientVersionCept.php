<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('检查更新');
//有的检测
$URL = '/api/appclient/ver/info/1000';
$I->amOnPage($URL);
$I->see('"msg":1');
$I->see('"VersionCode":"2001"');
$I->see('"AddTime":"2014\/10\/27 00:00:00"');
$I->see('"DownUrl":"http:\/\/thisisatest.apk"');

$URL = '/api/appclient/ver/info/1002';
$I->amOnPage($URL);
$I->see('"msg":1');
$I->see('"VersionCode":"2001"');


$URL = '/api/appclient/ver/info/1000';
$I->amOnPage($URL);
$I->see('"msg":1');
$I->see('"VersionCode":"2001"');

//错误测试
$URL = '/api/appclient/ver/info/5000';
$I->amOnPage($URL);
$I->see('"msg":0');
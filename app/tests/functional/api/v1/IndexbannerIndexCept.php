<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('首页图片获取');
//BANNER图获取
$I->sendAjaxGetRequest('/api/game/extend/banner/4/1');
$I->see('"msg":1');
$I->see('"pageCount":1');
$I->see('"recordCount":2');
$I->see('"id":"3"');
$I->see('ImgUrl');

//hot列表
$I->sendAjaxGetRequest('/api/game/extend/hot/4/2');
$I->see('"msg":1');
$I->see('"pageCount":2');
$I->see('"recordCount":6');
$I->see('"id":"3"');
$I->see('ImgUrl');

//最新列表
$I->sendAjaxGetRequest('/api/game/extend/new/4/1');
$I->see('"msg":1');
$I->see('"pageCount":3');
$I->see('"recordCount":10');
$I->see('"id":"2"');
$I->see('ImgUrl');

//错误
$I->sendAjaxGetRequest('/api/game/extend/hot1/4/2');
$I->see('"msg":0');
$I->sendAjaxGetRequest('/api/game/extend/hot/0/2');
$I->see('"msg":0');
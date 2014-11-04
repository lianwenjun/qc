<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('游戏广告列表');
//首页游戏
$I->sendAjaxGetRequest('/v1/game/list/new/4/1');
$I->see('"msg":1');
$I->see('"pageCount":1');
$I->see('"recordCount":2');
$I->see('"id":3');
$I->see('modelList');
$I->see('commentCnt');
$I->see('downloadCnt');
$I->see('id');
$I->see('downUrl');
$I->see('name');
$I->see('score');
$I->see('versionCode');
$I->see('size');
$I->see('version');
$I->see('logoImageurl');
$I->see('md5');
$I->see('gameCategory');
$I->see('packageName');

$I->sendAjaxGetRequest('/v1/game/list/hot/4/1');
$I->see('"msg":1');
$I->see('"pageCount":1');
$I->see('"recordCount":2');

$I->sendAjaxGetRequest('/v1/game/list/hot/4/2');
$I->see('"msg":1');
$I->see('"pageCount":1');
$I->see('"recordCount":2');


$I->sendAjaxGetRequest('/v1/game/list/search/4/1');
$I->see('"msg":1');
$I->see('"pageCount":2');
$I->see('"recordCount":5');

//排行游戏
$I->sendAjaxGetRequest('/v1/game/list/new/10/1');
$I->see('"msg":1');
$I->see('"pageCount":1');
$I->see('"recordCount":1');
$I->see('"id":3');

$I->sendAjaxGetRequest('/v1/game/list/hot/10/1');
$I->see('"msg":1');
$I->see('"pageCount":1');
$I->see('"recordCount":2');
$I->see('"id":3');

$I->sendAjaxGetRequest('/v1/game/list/surge/10/1');
$I->see('"msg":1');
$I->see('"pageCount":1');
$I->see('"recordCount":1');
$I->see('"id":3');

//错误的
$I->sendAjaxGetRequest('/v1/game/list/xx/4/1');
$I->see('"msg":1');

$I->sendAjaxGetRequest('/v1/game/list/xx/10/1');
$I->see('"msg":1');

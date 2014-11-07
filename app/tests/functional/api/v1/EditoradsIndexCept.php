<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('编辑精选广告列表');
//首页编辑精选
$I->sendAjaxGetRequest('/v1/api/game/cull/cull/4/1');
$I->see('"msg":1');
$I->see('"pageCount":3');
$I->see('"recordCount":10');
$I->see('"id":"3"');
$I->see('modelList');
$I->see('id');
$I->see('ImgUrl');
$I->see('advert');
$I->see('downUrl');
$I->see('name');
$I->see('versionCode');
$I->see('size');
$I->see('version');
$I->see('logourl');
$I->see('md5');
$I->see('gameCategory');
$I->see('packageName');

//所有的编辑精选
$I->sendAjaxGetRequest('/v1/api/game/cull/all/10/1');
$I->see('"msg":1');
$I->see('"pageCount":2');
$I->see('"recordCount":13');
$I->see('"id":"3"');
$I->see('ImgUrl');

//错误的
$I->sendAjaxGetRequest('/v1/api/game/cull/xx/4/1');
$I->see('"msg":0');
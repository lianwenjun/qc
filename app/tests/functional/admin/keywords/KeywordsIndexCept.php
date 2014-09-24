<?php
/*
* 关键字列表读取
*/ 
$I = new FunctionalTester($scenario);
$I->wantTo('关键字列表功能');
$I->amOnPage('admin/keyword/index');
//检测ACTION和ROUTENAME
$I->seeCurrentRouteIs('keyword.index');
$I->seeCurrentActionIs('Admin_KeywordsController@index');
//检测列表

//检测点击
//关键字添加
$I->see('添加');
//关键字查询
$I->see('查询');
//下一页
//$I->see('下一页');
//
$I->see('编辑');
//
//$I->see('删除');
//$I->seeLink();
//检测列表
$I->seeNumberOfElements('tr', [0,10]);


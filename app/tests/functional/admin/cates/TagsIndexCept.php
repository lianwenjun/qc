<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('游戏标签列表页');
$I->amOnPage('admin/tag/index');
//检测ACTION和ROUTENAME
$I->seeCurrentRouteIs('tag.index');
$I->seeCurrentActionIs('Admin_CatesController@tagIndex');
$I->see('游戏标签管理');

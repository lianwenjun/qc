<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('分类页面');
$I->amOnPage('admin/cate/index');
//检测ACTION和ROUTENAME
$I->seeCurrentRouteIs('cate.index');
$I->seeCurrentActionIs('Admin_CatesController@index');
$I->see('分类标签管理');


<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('获得分类的详细标签列表');
//存在检测
$I->sendAjaxGetRequest('/admin/cate/1/show'); // GET
$I->see('error');
//不存在检测
/*
$I->sendAjaxGetRequest('/admin/cate/150'); // GET
$I->see('error');
$I->sendAjaxGetRequest('/admin/cate/-1'); // GET
$I->see('error');
$I->sendAjaxGetRequest('/admin/cate/abc'); // GET
$I->see('error');*/

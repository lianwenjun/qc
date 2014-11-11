<?php
/*
    应用反馈列表: 已创建的反馈数据

        id 1  内容  应用反馈列表第一行内容  imei  A0000045F37F88  创建时间  2014-10-14 10:33:12
        id 2  内容  应用反馈列表第二行内容  imei  ABCDEF45F37F88  创建时间  2014-10-16 10:33:12
        id 3  内容  应用反馈列表第三行内容  imei  A0000045F37F88  创建时间  2014-10-18 10:33:12

*/
$I = new FunctionalTester($scenario);
$I->wantTo('应用反馈列表功能');

// 登陆
$I->sendAjaxRequest('put', '/admin/users/signin', ['username' => 'test', 'password' => 'test']);

$I->amOnRoute('feedback.index');
$I->see('应用反馈列表');
$I->see('应用反馈列表第一行内容');
$I->see('应用反馈列表第二行内容');
$I->see('应用反馈列表第三行内容');

// ID搜索
$I->sendAjaxGetRequest('/admin/feedback/index?type=id&keyword=1&created_at[]=&created_at[]=');
$I->see('应用反馈列表第一行内容');
$I->dontSee('应用反馈列表第二行内容');
$I->dontSee('应用反馈列表第三行内容');

// IMEI搜索
$I->sendAjaxGetRequest('/admin/feedback/index?type=imei&keyword=ABCDEF&created_at[]=&created_at[]=');
$I->see('应用反馈列表第二行内容');
$I->dontSee('应用反馈列表第一行内容');
$I->dontSee('应用反馈列表第三行内容');

// 内容搜索
$I->sendAjaxGetRequest('/admin/feedback/index?type=content&keyword=第二行&created_at[]=&created_at[]=');
$I->see('应用反馈列表第二行内容');
$I->dontSee('应用反馈列表第一行内容');
$I->dontSee('应用反馈列表第三行内容');

// 时间搜索
$I->sendAjaxGetRequest('/admin/feedback/index?type=&keyword=&created_at[]=2014-10-17&created_at[]=2014-10-18');
$I->see('应用反馈列表第三行内容');
$I->dontSee('应用反馈列表第一行内容');
$I->dontSee('应用反馈列表第二行内容');


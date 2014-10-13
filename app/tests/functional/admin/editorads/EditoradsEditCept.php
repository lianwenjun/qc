<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('编辑编辑精选广告页面测试');
//打开添加页面
//游戏不存在
$I->amOnpage('/admin/editorads/25/edit');
$I->seeSessionHasValues(['msg' => '没发现游戏数据']);
//正常数据
$I->amOnpage('/admin/editorads/29/edit');
$I->see('编辑');
$I->click('返回列表');


//发送数据
$fields = [
    'location' => 'hotdown', 
    'image' => 'xxxoxoxo.jpg',
    'is_top' => 'yes',
    'onshelfed_at' => '1411720308',
    'offshelfed_at' => '1411720308',
    'word' => '数据测试来idea',
    ];
//foreach($fields as $index => $field){
//    $I->fillField($index, $field);
//}
//$I->click('Submit');

//AJAX测试
$I->sendAjaxPostRequest('/admin/editorads/25/edit', $fields);
$I->seeSessionHasValues(['msg' => '修改成功']);
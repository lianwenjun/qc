<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('首页游戏位广告添加');
$I->amOnPage('/admin/appsads/create');
//$I->see('添加游戏');
$fields = ['app_id'=> 1, 
    'title' => '无耻的APP测试包', 
    'location' => 'hotdown', 
    'image' => 'xxxoxoxo.jpg',
    'is_top' => 'no',
    'onshelfed_at' => '1411720308',
    'offshelfed_at' => '1411720308',
    ];
//foreach($fields as $index => $field){
//    $I->fillField($index, $field);
//}
//$I->click('Submit');

//AJAX测试
$I->sendAjaxPostRequest('/admin/appsads/create', $fields);
$I->seeSessionHasValues(['msg' => '添加成功']);
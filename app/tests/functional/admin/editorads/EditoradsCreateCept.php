<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('添加编辑精选广告页面测试');
//先登录
$data = ['username' => 'test', 'password' => 'test'];
$I->sendAjaxRequest('PUT', '/admin/users/signin', $data);


//打开添加页面
$I->amOnpage('/admin/editorads/create');
$I->see('添加');
$I->click('返回列表');


//发送数据
$fields = ['app_id'=> 1, 
    'title' => '无耻的APP测试包', 
    'location' => 'hotdown', 
    'image' => 'xxxoxoxo.jpg',
    'is_top' => 'no',
    'stocked_at' => '1411720308',
    'unstocked_at' => '1411720308',
    'word' => '数据测试来idea',
    ];
//foreach($fields as $index => $field){
//    $I->fillField($index, $field);
//}
//$I->click('Submit');

//AJAX测试
$I->sendAjaxPostRequest('/admin/editorads/create', $fields);
$I->seeSessionHasValues(['msg' => '添加成功']);
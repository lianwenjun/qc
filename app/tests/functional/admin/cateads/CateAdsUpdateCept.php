<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('更新分类广告的数据');
$I->sendAjaxPostRequest('/admin/cateads/2/update', ['image' => 'xxxxx2222222.jpg']);
$I->see('ok');

$I->sendAjaxPostRequest('/admin/cateads/1/update', ['image' => 'xxxxx2222222.jpg']);
$I->see('valid');

$I->sendAjaxPostRequest('/admin/cateads/3/update', ['image1' => 'xxxxx2222222.jpg']);
$I->see('error');
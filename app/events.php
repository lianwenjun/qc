<?php
/*
 * 订阅事件 actionLog
 *
 */

Event::listen('actionLog', function($activity, $contentId)
{
    // 获取contentType
    $contentTypeArr = [
        'app' => '游戏',
        'appsads' => '广告',
        'rankads' => '广告',
        'indexads' => '广告',
        'editorads' => '广告',
        'catads' => '分类广告',
        'cat' => '分类',
        'tag' => '标签',
        'keyword' => '关键字',
        'stopword' => '屏蔽词',
        'rating' => '评分',
        'comment' => '评论',
        'users' => '管理员',
        'roles' => '角色'
    ];
    $routeHead = explode('.', Route::getCurrentRoute())[0];
    $contentType = $contentTypeArr[$routeHead];

    // 获取操作信息
    $activityLogs = array_dot(Config::get('activityLogs'));
    foreach ($activityLogs as $k => $v) {
        if ($activity == $v) {
            $activityStr = $k;
            break;
        }
    }
    $activityArr = explode('.', $activityStr);
    $action = $activityArr[2];
    $actionModel = $activityArr[0] . '-' . $activityArr[1];

    // 获取用户信息
    $username = Sentry::getUser()->userName;
    $realName = Sentry::getUser()->realName;
    
    // 存入日志数据
    if (is_array($contentId)) {
        foreach ($contentId as $cid) {
            Activity::log([
                'contentId'   => $cid,
                'contentType' => 'User',
                'action'      => 'Create',
                'description' => 'Created a User',
                'details'     => 'Username: '.$user->username,
                'updated'     => $id ? true : false,
            ]);
        }
    } elseif (is_int($contentId)) {
        Activity::log([
            'contentId'   => $contentId,
            'contentType' => 'User',
            'action'      => 'Create',
            'description' => 'Created a User',
            'details'     => 'Username: '.$user->username,
            'updated'     => $id ? true : false,
        ]);
    }

});
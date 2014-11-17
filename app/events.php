<?php
/*
 * 订阅事件 actionLog
 *
 */

Event::listen('actionLog', function($logData)
{

    // 获取用户信息
    $username = Sentry::getUser()->username;
    $realname = Sentry::getUser()->realname;

    // 存入日志数据
    if (is_array($logData['contentId'])) {
        foreach ($logData['contentId'] as $cid) {
            Activity::log([
                'contentId'   => $cid,
                'username'    => $username,
                'realname'    => $realname,
                'contentType' => $logData['contentType'],
                'action'      => $logData['action'],
                'description' => $logData['description'],
            ]);
        }
    } else {
        Activity::log([
            'contentId'   => $logData['contentId'],
            'username'    => $username,
            'realname'    => $realname,
            'contentType' => $logData['contentType'],
            'action'      => $logData['action'],
            'description' => $logData['description'],
        ]);
    }

});
// {

//     // 获取用户信息
//     $username = Sentry::getUser()->username;
//     $realname = Sentry::getUser()->realname;
    
//     // 存入日志数据
//     if (is_array($contentId)) {
//         foreach ($contentId as $cid) {
//             Activity::log([
//                 'contentId'   => $cid,
//                 'username'    => $username,
//                 'realname'    => $realname,
//                 'contentType' => $contentType,
//                 'action'      => $action,
//                 'description' => $description,
//             ]);
//         }
//     } else {
//         Activity::log([
//             'contentId'   => $contentId,
//             'username'    => $username,
//             'realname'    => $realname,
//             'contentType' => $contentType,
//             'action'      => $action,
//             'description' => $description,
//         ]);
//     }

// });
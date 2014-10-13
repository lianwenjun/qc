<?php
/**
 * 权限 & 组定义
 *
 * 用于分组展示以及显示中文
 */

return [
    '上架游戏列表' => [
        'apps.onshelf' => '列表',
        'apps.dooffshelf' => '下架',
        'apps.edit' => '编辑',
        'apps.history' => '历史',

        ],
    '添加编辑游戏' => [
        'apps.draft' => '列表',
        'apps.delete' => '删除',
        'apps.appupload' => 'APK上传',
        ],
    '待审核列表' => [
        'apps.pending' => '列表',
        'apps.dopass' => '审核通过',
        'apps.donopass' => '审核不通过',
        'apps.doallpass' => '批量审核通过',
        'apps.doallnopass' => '批量审核不通过',
        ],
    '审核不通过列表' => [
        'apps.nopass' => '列表',
    ],
    '下架游戏列表' => [
        'apps.offshelf' => '列表',
    ]
];
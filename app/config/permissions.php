<?php
/**
 * 权限 & 组定义
 *
 * 用于分组展示以及显示中文
 */

return [
    '上架游戏列表' => [
        'apps.stock' => '列表',
        'apps.putUnstock' => '下架',
        'apps.stock.edit' => '编辑',
        'apps.history' => '历史',
        'apps.preview' => '预览'
        ],
    '添加编辑游戏' => [
        'apps.draft' => '列表',
        'apps.delete' => '删除',
        'apps.draft.edit' => '编辑',
        'apps.appupload' => 'APK上传',
        'apps.imageupload' => '图片上传',
        'apps.iconupload' => '游戏icon上传',
        ],
    '待审核列表' => [
        'apps.pending' => '列表',
        'apps.putStock' => '审核通过',
        'apps.putNotpass' => '审核不通过',
        'apps.pending.edit' => '提交到待审核',
        ],
    '审核不通过列表' => [
        'apps.notpass' => '列表',
        'apps.notpass.edit' => '编辑',
    ],
    '下架游戏列表' => [
        'apps.unstock' => '列表',
        'apps.unstock.edit' => '编辑',
    ],
    '首页游戏位管理' => [
        'appsads.index' => '列表',
        'appsads.create' => '新增',
        'appsads.unstock' => '下架',
        'appsads.edit' => '编辑',
        'appsads.delete' => '删除',
        'appsads.upload' => '上传',
    ],
    '排行游戏位管理' => [
        'rankads.index' => '列表',
        'rankads.create' => '新增',
        'rankads.unstock' => '下架',
        'rankads.edit' => '编辑',
        'rankads.delete' => '删除',
    ],
    '首页图片位管理' => [
        'indexads.index' => '列表',
        'indexads.create' => '新增',
        'indexads.unstock' => '下架',
        'indexads.edit' => '编辑',
        'indexads.delete' => '删除',

    ],
    '编辑精选管理' => [
        'editorads.index' => '列表',
        'editorads.create' => '新增',
        'editorads.unstock' => '下架',
        'editorads.edit' => '编辑',
        'editorads.delete' => '删除',
    ],
    '分类页图片位推广' => [
        'catads.index' => '列表',
        'catads.upload' => '上传',
        'catads.edit' => '编辑',
    ],
    '游戏分类管理' => [
        'cat.index' => '列表',
        'cat.create' => '新增',
        'cat.edit' => '编辑',
        'cat.delete' => '删除',
        'cat.show' => '查看',
    ],
    '游戏标签管理' => [
        'tag.index' => '列表',
        'tag.create' => '新增',
        'tag.edit' => '编辑',
        'tag.delete' => '删除',
        'tag.show' => '查看',
    ],
    '游戏评分列表' => [
        'rating.index' => '列表',
        'rating.edit' => '编辑',
    ],
    '游戏评论列表' => [
        'comment.index' => '列表',
        'comment.edit' => '编辑',
        'comment.delete' => '删除',
    ],
    '应用反馈' => [
        'feedback.index' => '列表',
    ],
    '屏蔽词管理' => [
        'stopword.index' => '列表',
        'stopword.create' => '新增',
        'stopword.edit' => '编辑',
        'stopword.delete' => '删除',
    ],
    '关键字管理' => [
        'keyword.index' => '列表',
        'keyword.store' => '新增',
        'keyword.update' => '编辑',
        'keyword.delete' => '删除',
    ],
    '管理员管理' => [
        'users.index' => '列表',
        'users.create' => '新增',
        'users.edit' => '编辑',
        'users.delete' => '删除',
    ],
    '角色管理' => [
        'roles.index' => '列表',
        'roles.create' => '新增',
        'roles.edit' => '编辑',
        'roles.delete' => '删除',
    ],
    '日志管理' => [
        'log.index' => '列表',
    ],
    '数据中心' => [
        'statistics.appdownloads' => '游戏下载统计',
    ],
    '版本管理' => [
        'client.index' => '列表',
        'client.create' => '新增',
        'client.edit' => '修改',
        'client.apkupload' => '上传',
    ],
];
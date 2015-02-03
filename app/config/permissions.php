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
        'apps.preview' => '预览',
        'apps.iconupload' => '游戏icon上传',
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
        'apps.iconupload' => '游戏icon上传',
    ],
    '下架游戏列表' => [
        'apps.unstock' => '列表',
        'apps.unstock.edit' => '编辑',
        'apps.iconupload' => '游戏icon上传',
    ],
    '首页图片位管理' => [
        'banners.index' => '列表',
        'banners.create' => '新增',
        'banners.unstock' => '下架',
        'banners.edit' => '编辑',
        'banners.delete' => '删除'
    ],
    '首页游戏位管理' => [
        'ads.apps.index' => '列表',
        'ads.apps.create' => '新增',
        'ads.apps.unstock' => '下架',
        'ads.apps.edit' => '编辑',
        'ads.apps.delete' => '删除',
    ],
    '排行游戏位管理' => [
        'ads.ranks.index' => '列表',
        'ads.ranks.create' => '新增',
        'ads.ranks.unstock' => '下架',
        'ads.ranks.edit' => '编辑',
        'ads.ranks.delete' => '删除',
    ],
    '精选必玩管理' => [
        'ads.choice.index' => '列表',
        'ads.choice.create' => '新增',
        'ads.choice.unstock' => '下架',
        'ads.choice.edit' => '编辑',
        'ads.choice.delete' => '删除',
    ],
    '编辑推荐管理' => [
        'editorads.index' => '列表',
        'editorads.create' => '新增',
        'editorads.unstock' => '下架',
        'editorads.edit' => '编辑',
        'editorads.delete' => '删除',
        'editorads.upload' => '图片上传'
    ],
    '分类页图片位推广' => [
        'catads.index' => '列表',
        'catads.upload' => '上传',
        'catads.edit' => '编辑',
    ],
    '游戏分类管理' => [
        'cats.index' => '列表',
        'cats.create' => '新增',
        'cats.edit' => '编辑',
        'cats.delete' => '删除',
        'cats.show' => '查看',
    ],
    '游戏标签管理' => [
        'tags.index' => '列表',
        'tags.create' => '新增',
        'tags.edit' => '编辑',
        'tags.delete' => '删除',
        'tags.show' => '查看',
    ],
    '游戏分类标签管理' => [
        'gamecattags.index' => '列表',
        'gamecattags.create' => '新增',
        'gamecattags.delete' => '删除',
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
        'statistics.exportdownloads' => '导出下载统计数据',
    ],
    '版本管理' => [
        'client.index' => '列表',
        'client.create' => '新增',
        'client.edit' => '修改',
        'client.apkupload' => '上传',
        'channels.store' => '添加渠道号',
    ],
    // 新增专题广告
    '专题广告' => [
        'edittopics.index' => '编辑专题列表',
        'stocktopics.index' => '上架专题列表',
        'topics.create' => '新增',
        'topics.edit' => '编辑',
        'topics.show' => '查看',
        'topics.delete' => '删除',
        'topics.unstock' => '下架',
        'topics.revocate' => '撤销'
    ]

];
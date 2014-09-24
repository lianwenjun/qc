/* Replace this file with actual dump of your database */


/*----------------------------------------------------------
| 测试添加编辑游戏数据库
----------------------------------------------------------*/
CREATE TABLE `apps` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `icon` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'ICON',
  `title` varchar(128) COLLATE utf8_unicode_ci NOT NULL COMMENT '游戏名',
  `pack` varchar(128) COLLATE utf8_unicode_ci NOT NULL COMMENT '包名',
  `size` int(10) unsigned NOT NULL COMMENT '游戏大小KB',
  `version` varchar(32) COLLATE utf8_unicode_ci NOT NULL COMMENT '游戏版本',
  `author` varchar(128) COLLATE utf8_unicode_ci NOT NULL COMMENT '游戏作者',
  `summary` text COLLATE utf8_unicode_ci NOT NULL COMMENT '游戏简介',
  `images` text COLLATE utf8_unicode_ci NOT NULL COMMENT '游戏图片',
  `changes` text COLLATE utf8_unicode_ci NOT NULL COMMENT '游戏特性',
  `reason` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT '审核不过原因',
  `download_counts` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '总下载量',
  `download_manual` varchar(32) COLLATE utf8_unicode_ci NOT NULL COMMENT '人工用于显示下载量',
  `download_link` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'APK下载路径',
  `operator` int(11) NOT NULL COMMENT '操作者',
  `os` varchar(32) COLLATE utf8_unicode_ci NOT NULL COMMENT '系统OS',
  `os_version` varchar(32) COLLATE utf8_unicode_ci NOT NULL COMMENT '系统版本',
  `status` enum('new','draft','pending','nopass','onshelf','offshelf') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'new' COMMENT '数据状态',
  `is_verify` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no' COMMENT '是否安全认证',
  `has_ad` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no' COMMENT '是否无广告',
  `onshelfed_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '上架时间',
  `offshelfed_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '下架时间',
  `reviewed_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '审核时间',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


/* 测试草稿*/
INSERT INTO `apps` (`id`, `icon`, `title`, `pack`, `size`, `version`, `author`, `summary`, `images`, `changes`, `reason`, `download_counts`, `download_manual`, `download_link`, `operator`, `os`, `os_version`, `status`, `is_verify`, `has_ad`, `onshelfed_at`, `offshelfed_at`, `reviewed_at`, `deleted_at`, `created_at`, `updated_at`)
VALUES
    (1,'/icons/0/4/0420dd2a485e9978e78248c6d8aea840.png','上传游戏A君','cn.shangcm.boxz.android',27,'1.0.2','','','','','',0,'','/apks/5/8/58c0c78ab05fbfc518136c50e255ca16.apk',0,'','','new','no','no','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'2014-09-03 08:04:46','2014-09-23 08:04:46'),
    (2,'/icons/6/8/68745070802f9b8addf6db640d86eeff.png','上传游戏B君','my.app.tcp',157,'1.0','','','','','',0,'','/apks/3/9/3934bc5f9504a26baf546483b595f45a.apk',0,'','','new','no','no','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'2014-09-01 09:24:02','2014-09-23 09:24:02'),
    (3,'/icons/f/e/febeb565db27cf439b414798fdc7a5a6.png','填充游戏A君','',350,'1.50','','','','','',0,'','/apks/a/9/a94fb9264643673fa6b54fb996cc0d70.apk',0,'','','new','no','no','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'2014-09-23 09:24:46','2014-09-24 02:35:37'),
    (4,'/icons/f/e/febeb565db27cf439b414798fdc7a5a6.png','可怜软件A君','',350,'1.50','','','','','',0,'','/apks/a/9/a94fb9264643673fa6b54fb996cc0d70.apk',0,'','','new','no','no','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'2014-09-23 09:24:46','2014-09-24 02:35:37'),
    (444,'/icons/f/e/febeb565db27cf439b414798fdc7a5a6.png','删除游戏A君','',350,'1.50','','','','','',0,'','/apks/a/9/a94fb9264643673fa6b54fb996cc0d70.apk',0,'','','new','no','no','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'2014-09-23 09:24:46','2014-09-24 02:35:37');
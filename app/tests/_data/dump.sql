/* Replace this file with actual dump of your database */


/*----------------------------------------------------------
| 测试 apps 数据库
----------------------------------------------------------*/
DROP TABLE IF EXISTS `apps`;

CREATE TABLE `apps` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `icon` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'ICON',
  `title` varchar(128) COLLATE utf8_unicode_ci NOT NULL COMMENT '游戏名',
  `pack` varchar(128) COLLATE utf8_unicode_ci NOT NULL COMMENT '包名',
  `size` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT '游戏大小',
  `size_int` int(10) unsigned NOT NULL COMMENT '游戏大小查询用',
  `version` varchar(32) COLLATE utf8_unicode_ci NOT NULL COMMENT '游戏版本',
  `version_code` varchar(32) COLLATE utf8_unicode_ci NOT NULL COMMENT '版本代号',
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
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
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
INSERT INTO `apps` (`id`, `icon`, `title`, `pack`, `size_int`, `size`, `version`, `author`, `summary`, `images`, `changes`, `reason`, `download_counts`, `download_manual`, `download_link`, `operator`, `os`, `os_version`, `sort`, `status`, `is_verify`, `has_ad`, `onshelfed_at`, `offshelfed_at`, `reviewed_at`, `deleted_at`, `created_at`, `updated_at`)
VALUES
    (1,'/icons/0/4/0420dd2a485e9978e78248c6d8aea840.png','上传游戏A君','','27 KB',27,'1.0.2','','','','','',0,'','/apks/5/8/58c0c78ab05fbfc518136c50e255ca16.apk',0,'','',99,'new','no','no','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'2014-09-03 10:00:00','2014-09-23 08:04:46'),
    (2,'/icons/6/8/68745070802f9b8addf6db640d86eeff.png','上传游戏B君','','157 KB',157,'1.0','','','','','',0,'','/apks/3/9/3934bc5f9504a26baf546483b595f45a.apk',0,'','',98,'new','no','no','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'2014-09-01 10:00:00','2014-09-23 09:24:02'),
    (3,'/icons/f/e/febeb565db27cf439b414798fdc7a5a6.png','填充游戏君','','350 KB',350,'1.50','','','','','',0,'','/apks/a/9/a94fb9264643673fa6b54fb996cc0d70.apk',0,'','',97,'new','no','no','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'2014-09-23 09:24:46','2014-09-24 02:35:37'),
    (4,'/icons/f/e/febeb565db27cf439b414798fdc7a5a6.png','可怜软件A君','','350 KB',350,'1.50','','','','','',0,'','/apks/a/9/a94fb9264643673fa6b54fb996cc0d70.apk',0,'','',96,'new','no','no','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'2014-09-02 10:00:00','2014-09-24 02:35:37'),
    (5,'/icons/f/e/febeb565db27cf439b414798fdc7a5a6.png','填充游戏君','','350 KB',350,'1.50','','','','','',0,'','/apks/a/9/a94fb9264643673fa6b54fb996cc0d70.apk',0,'','',95,'new','no','no','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'2014-09-23 09:24:46','2014-09-24 02:35:37'),
    (6,'/icons/f/e/febeb565db27cf439b414798fdc7a5a6.png','填充游戏君','','350 KB',350,'1.50','','','','','',0,'','/apks/a/9/a94fb9264643673fa6b54fb996cc0d70.apk',0,'','',94,'new','no','no','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'2014-09-23 09:24:46','2014-09-24 02:35:37'),
    (7,'/icons/f/e/febeb565db27cf439b414798fdc7a5a6.png','填充游戏君','','350 KB',350,'1.50','','','','','',0,'','/apks/a/9/a94fb9264643673fa6b54fb996cc0d70.apk',0,'','',93,'new','no','no','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'2014-09-23 09:24:46','2014-09-24 02:35:37'),
    (8,'/icons/f/e/febeb565db27cf439b414798fdc7a5a6.png','上传游戏D君','','350 KB',350,'1.50','','','','','',0,'','/apks/a/9/a94fb9264643673fa6b54fb996cc0d70.apk',0,'','',92,'new','no','no','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'2014-09-23 09:24:46','2014-09-24 02:35:37'),
    (9,'/icons/f/e/febeb565db27cf439b414798fdc7a5a6.png','草稿游戏A君','','350 KB',350,'1.50','','','','','',0,'','/apks/a/9/a94fb9264643673fa6b54fb996cc0d70.apk',0,'','',91,'draft','no','no','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'2014-09-23 09:24:46','2014-09-24 02:35:37'),
    (10,'/icons/f/e/febeb565db27cf439b414798fdc7a5a6.png','填充游戏君','','350 KB',350,'1.50','','','','','',0,'','/apks/a/9/a94fb9264643673fa6b54fb996cc0d70.apk',0,'','',90,'new','no','no','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'2014-09-23 09:24:46','2014-09-24 02:35:37'),
    (11,'/icons/f/e/febeb565db27cf439b414798fdc7a5a6.png','填充游戏君','','350 KB',350,'1.50','','','','','',0,'','/apks/a/9/a94fb9264643673fa6b54fb996cc0d70.apk',0,'','',89,'new','no','no','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'2014-09-23 09:24:46','2014-09-24 02:35:37'),
    (12,'/icons/f/e/febeb565db27cf439b414798fdc7a5a6.png','填充游戏君','','350 KB',350,'1.50','','','','','',0,'','/apks/a/9/a94fb9264643673fa6b54fb996cc0d70.apk',0,'','',87,'new','no','no','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'2014-09-23 09:24:46','2014-09-24 02:35:37'),
    (13,'/icons/f/e/febeb565db27cf439b414798fdc7a5a6.png','填充游戏君','','350 KB',350,'1.50','','','','','',0,'','/apks/a/9/a94fb9264643673fa6b54fb996cc0d70.apk',0,'','',86,'new','no','no','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'2014-09-23 09:24:46','2014-09-24 02:35:37'),
    (14,'/icons/f/e/febeb565db27cf439b414798fdc7a5a6.png','填充游戏君','','350 KB',350,'1.50','','','','','',0,'','/apks/a/9/a94fb9264643673fa6b54fb996cc0d70.apk',0,'','',85,'new','no','no','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'2014-09-23 09:24:46','2014-09-24 02:35:37'),
    (15,'/icons/f/e/febeb565db27cf439b414798fdc7a5a6.png','填充游戏君','','350 KB',350,'1.50','','','','','',0,'','/apks/a/9/a94fb9264643673fa6b54fb996cc0d70.apk',0,'','',84,'new','no','no','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'2014-09-23 09:24:46','2014-09-24 02:35:37'),
    (16,'/icons/f/e/febeb565db27cf439b414798fdc7a5a6.png','填充游戏君','','350 KB',350,'1.50','','','','','',0,'','/apks/a/9/a94fb9264643673fa6b54fb996cc0d70.apk',0,'','',83,'new','no','no','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'2014-09-23 09:24:46','2014-09-24 02:35:37'),
    (17,'/icons/f/e/febeb565db27cf439b414798fdc7a5a6.png','填充游戏君','','350 KB',350,'1.50','','','','','',0,'','/apks/a/9/a94fb9264643673fa6b54fb996cc0d70.apk',0,'','',82,'new','no','no','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'2014-09-23 09:24:46','2014-09-24 02:35:37'),
    (18,'/icons/f/e/febeb565db27cf439b414798fdc7a5a6.png','填充游戏君','','350 KB',350,'1.50','','','','','',0,'','/apks/a/9/a94fb9264643673fa6b54fb996cc0d70.apk',0,'','',81,'new','no','no','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'2014-09-23 09:24:46','2014-09-24 02:35:37'),
    (19,'/icons/f/e/febeb565db27cf439b414798fdc7a5a6.png','填充游戏君','','350 KB',350,'1.50','','','','','',0,'','/apks/a/9/a94fb9264643673fa6b54fb996cc0d70.apk',0,'','',80,'new','no','no','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'2014-09-23 09:24:46','2014-09-24 02:35:37'),
    (20,'/icons/f/e/febeb565db27cf439b414798fdc7a5a6.png','填充游戏君','','350 KB',350,'1.50','','','','','',0,'','/apks/a/9/a94fb9264643673fa6b54fb996cc0d70.apk',0,'','',79,'new','no','no','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'2014-09-23 09:24:46','2014-09-24 02:35:37'),
    (21,'/icons/f/e/febeb565db27cf439b414798fdc7a5a6.png','分页游戏A君','','350 KB',350,'1.50','','','','','',0,'','/apks/a/9/a94fb9264643673fa6b54fb996cc0d70.apk',0,'','',78,'new','no','no','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'2014-09-23 09:24:46','2014-09-24 02:35:37'),
    (22,'/icons/f/e/febeb565db27cf439b414798fdc7a5a6.png','分页游戏B君','','350 KB',350,'1.50','','','','','',0,'','/apks/a/9/a94fb9264643673fa6b54fb996cc0d70.apk',0,'','',77,'new','no','no','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'2014-09-23 09:24:46','2014-09-24 02:35:37'),
    (444,'/icons/f/e/febeb565db27cf439b414798fdc7a5a6.png','删除游戏A君','','350 KB',350,'1.50','','','','','',0,'','/apks/a/9/a94fb9264643673fa6b54fb996cc0d70.apk',0,'','',76,'new','no','no','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'2014-09-23 09:24:46','2014-09-24 02:35:37');

/*----------------------------------------------------------
| 测试 cates 数据库
----------------------------------------------------------*/
DROP TABLE IF EXISTS `cates`;

CREATE TABLE `cates` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '父类分类ID',
  `search_total` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '自然搜索量',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '分类排序',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)

) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `cates` (`id`, `title`, `parent_id`, `search_total`, `sort`, `deleted_at`, `created_at`, `updated_at`)
VALUES
  (1, '休闲益智', 0, 0, 0, NULL, '2014-09-26 02:42:10', '2014-09-26 02:42:10'),
  (2, '角色扮演', 0, 0, 0, NULL, '2014-09-26 02:42:10', '2014-09-26 02:42:10'),
  (24, '单机游戏', 0, 0, 0, NULL, '2014-09-26 02:42:10', '2014-09-26 02:42:10'),
  (25, '横版游戏', 0, 0, 0, NULL, '2014-09-26 02:42:24', '2014-09-26 02:42:24'),
  (26, '飞升游戏', 0, 0, 0, NULL, '2014-09-26 02:42:34', '2014-09-26 02:42:34'),
  (27, '来点东西', 0, 0, 0, NULL, '2014-09-26 05:35:36', '2014-09-26 05:35:36');


/*----------------------------------------------------------
| 测试 app_cates 数据库
----------------------------------------------------------*/
DROP TABLE IF EXISTS `app_cates`;

CREATE TABLE `app_cates` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `app_id` int(10) unsigned NOT NULL COMMENT '游戏ID',
  `cate_id` int(10) unsigned NOT NULL COMMENT '分类ID',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `app_cates` (`id`, `app_id`, `cate_id`, `created_at`, `updated_at`)
VALUES
  (1,1,1,'2014-09-29 09:22:39','2014-09-29 09:22:39'),
  (2,2,2,'2014-09-29 09:22:39','2014-09-29 09:22:39');




/*----------------------------------------------------------
| 测试 keywords 数据库
----------------------------------------------------------*/
DROP TABLE IF EXISTS `keywords`;

CREATE TABLE `keywords` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `word` varchar(16) COLLATE utf8_unicode_ci NOT NULL COMMENT '关键词',
  `search_total` int(11) NOT NULL DEFAULT '0' COMMENT '自然搜索量',
  `is_slide` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no' COMMENT '是否轮播',
  `creator` int(10) unsigned NOT NULL COMMENT '添加人',
  `operator` int(10) unsigned NOT NULL COMMENT '最后修改者',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


/*----------------------------------------------------------
| 测试 app_keywords 数据库
----------------------------------------------------------*/
DROP TABLE IF EXISTS `app_keywords`;

CREATE TABLE `app_keywords` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `app_id` int(10) unsigned NOT NULL COMMENT '游戏ID',
  `keyword_id` int(10) unsigned NOT NULL COMMENT '关键词ID',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


/*----------------------------------------------------------
| 测试 ads 数据库
----------------------------------------------------------*/

CREATE TABLE `ads` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `app_id` int(11) NOT NULL,
  `title` varchar(127) COLLATE utf8_unicode_ci NOT NULL COMMENT '游戏名',
  `location` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '广告区域',
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '图片路径',
  `word` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '广告词',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `type` enum('index','app','editor','rank') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'app' COMMENT '广告位分类',
  `is_onshelf` enum('yes','no','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no' COMMENT '是否上架',
  `is_top` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no' COMMENT '是否置顶',
  `onshelfed_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '上架时间',
  `offshelfed_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '下架时间',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `ads` (`id`, `app_id`, `title`, `location`, `image`, `word`, `sort`, `type`, `is_onshelf`, `is_top`, `onshelfed_at`, `offshelfed_at`, `deleted_at`, `created_at`, `updated_at`)
VALUES
  (1, 1, '植物大战僵尸', 'hotdown', '', '', 0, 'app', 'yes', 'no', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, '0000-00-00 00:00:00', '2014-09-26 09:06:32'),
  (2, 0, '', '', '', '', 0, 'app', 'no', 'no', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, '0000-00-00 00:00:00', '2014-09-26 09:20:23'),
  (3, 1, '植物大战僵尸', 'hotdown', '', '', 1, 'app', 'yes', 'no', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, '0000-00-00 00:00:00', '2014-09-26 09:05:42'),
  (4, 1, '植物大战僵尸', 'hotdown', '', '', 0, 'app', 'no', 'no', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, '0000-00-00 00:00:00', '2014-09-26 09:05:44'),
  (5, 1, '植物大战僵尸', '', '', '', 0, 'app', 'no', 'no', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2014-09-28 02:09:04', '0000-00-00 00:00:00', '2014-09-28 02:09:04'),
  (6, 1, '植物大战僵尸', 'hotdown', '', '', 100, 'app', 'no', 'yes', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2014-09-28 02:09:01', '0000-00-00 00:00:00', '2014-09-28 02:09:01');


INSERT INTO `ads` (`id`, `app_id`, `title`, `location`, `image`, `word`, `sort`, `type`, `is_onshelf`, `is_top`, `onshelfed_at`, `offshelfed_at`, `deleted_at`, `created_at`, `updated_at`)
VALUES
  (18, 4, '可怜软件A君', 'suggest', '/ads/3/e/3ee1125c624089a91a0d50695f3c17c4.jpg', '', 100, 'index', 'yes', 'no', '2014-09-29 12:00:00', '2014-09-30 12:00:00', NULL, '2014-09-29 10:00:07', '2014-09-29 16:50:54'),
  (19, 4, '可怜软件A君', 'suggest', '/ads/3/e/3ee1125c624089a91a0d50695f3c17c4.jpg', '', 100, 'index', 'yes', 'no', '2014-09-29 12:00:00', '2014-09-30 12:00:00', NULL, '2014-09-29 10:00:07', '2014-09-29 16:50:54'),
  (20, 4, '可怜软件A君', 'suggest', '/ads/3/e/3ee1125c624089a91a0d50695f3c17c4.jpg', '', 100, 'index', 'yes', 'no', '2014-09-29 12:00:00', '2014-09-30 12:00:00', NULL, '2014-09-29 10:00:07', '2014-09-29 16:50:54'),
  (21, 4, '可怜软件A君', 'suggest', '/ads/3/e/3ee1125c624089a91a0d50695f3c17c4.jpg', '', 100, 'index', 'yes', 'no', '2014-09-29 12:00:00', '2014-09-30 12:00:00', NULL, '2014-09-29 10:00:07', '2014-09-29 16:50:54'),
  (22, 4, '可怜软件A君', 'suggest', '/ads/3/e/3ee1125c624089a91a0d50695f3c17c4.jpg', '', 100, 'index', 'yes', 'no', '2014-09-29 12:00:00', '2014-09-30 12:00:00', NULL, '2014-09-29 10:00:07', '2014-09-29 16:50:54'),
  (23, 4, '可怜软件A君', 'suggest', '/ads/3/e/3ee1125c624089a91a0d50695f3c17c4.jpg', '', 100, 'index', 'yes', 'no', '2014-09-29 12:00:00', '2014-09-30 12:00:00', NULL, '2014-09-29 10:00:07', '2014-09-29 16:50:54'),
  (24, 4, '可怜软件A君', 'suggest', '/ads/3/e/3ee1125c624089a91a0d50695f3c17c4.jpg', '', 100, 'index', 'yes', 'no', '2014-09-29 12:00:00', '2014-09-30 12:00:00', NULL, '2014-09-29 10:00:07', '2014-09-29 16:50:54');


INSERT INTO `ads` (`id`, `app_id`, `title`, `location`, `image`, `word`, `sort`, `type`, `is_onshelf`, `is_top`, `onshelfed_at`, `offshelfed_at`, `deleted_at`, `created_at`, `updated_at`)
VALUES
  (25, 3, '填充游戏A君', 'new', '/ads/f/5/f54a84f41128eb877ec408ec40d82515.jpg', '对来点人那对来点人那', 0, 'editor', 'yes', 'yes', '2014-09-29 12:00:00', '2014-09-30 12:00:00', NULL, '2014-09-30 05:11:21', '2014-09-30 09:01:10'),
  (26, 3, '填充游戏A君', 'new', '/ads/f/5/f54a84f41128eb877ec408ec40d82515.jpg', '对来点人那', 0, 'editor', 'yes', 'yes', '2014-09-29 12:00:00', '2014-09-30 12:00:00', NULL, '2014-09-30 05:11:21', '2014-09-30 09:01:10'),
  (27, 3, '填充游戏A君', 'new', '/ads/f/5/f54a84f41128eb877ec408ec40d82515.jpg', '对来点人那', 0, 'editor', 'no', 'yes', '2014-09-29 12:00:00', '2014-09-30 12:00:00', '2014-10-08 03:18:53', '2014-09-30 05:11:21', '2014-10-08 03:18:53'),
  (28, 3, '填充游戏A君', 'new', '/ads/f/5/f54a84f41128eb877ec408ec40d82515.jpg', '输入游戏名称检测222', 0, 'editor', 'yes', 'no', '2014-10-06 11:08:44', '2014-10-08 12:00:00', NULL, '2014-09-30 05:11:21', '2014-10-08 03:31:46'),
  (29, 2, '上传游戏B君', 'hotdown', '/ads/9/e/9e70c11bb130005555bfe1cfa3b78ccf.jpg', '来点新东西', 0, 'editor', 'yes', 'yes', '2014-10-09 12:00:00', '2014-10-31 12:00:00', NULL, '2014-10-08 03:46:55', '2014-10-08 03:47:02');


/*----------------------------------------------------------
| 测试 cate_ads 数据库
----------------------------------------------------------*/

CREATE TABLE `cate_ads` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cate_id` int(10) unsigned NOT NULL COMMENT '分类ID',
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '分类名',
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '分类图片',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


INSERT INTO `cate_ads` (`id`, `cate_id`, `title`, `image`, `deleted_at`, `created_at`, `updated_at`)
VALUES
  (2, 24, '单机游戏', '', NULL, '2014-09-26 02:42:10', '2014-09-26 02:42:10'),
  (3, 25, '横版游戏', '', NULL, '2014-09-26 02:42:24', '2014-09-26 02:42:24'),
  (4, 26, '飞升游戏', '', NULL, '2014-09-26 02:42:34', '2014-09-26 02:42:34'),
  (5, 27, '来点东西', '', NULL, '2014-09-26 05:35:36', '2014-09-26 05:35:36');

/*----------------------------------------------------------
| 测试 stopword 数据库
----------------------------------------------------------*/

CREATE TABLE `stopwords` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `word` varchar(16) COLLATE utf8_unicode_ci NOT NULL COMMENT '替换词',
  `to_word` varchar(16) COLLATE utf8_unicode_ci NOT NULL DEFAULT '**' COMMENT '目标词',
  `creator` int(10) unsigned NOT NULL COMMENT '添加人',
  `operator` int(10) unsigned NOT NULL COMMENT '最后修改者',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `stopwords` (`id`, `word`, `to_word`, `creator`, `operator`, `deleted_at`, `created_at`, `updated_at`)
VALUES
  (1, '暴力', '**', 1, 1, NULL, '0000-00-00 00:00:00', '2014-10-08 16:12:42'),
  (2, '植物', '**', 1, 1, NULL, '2014-10-08 16:09:02', '2014-10-08 16:12:40'),
  (3, 'TG', '**', 1, 1, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
  (4, '来点新东西', '**', 1, 1, NULL, '2014-10-08 16:13:26', '2014-10-08 16:13:26'),
  (5, '国军', '**', 1, 1, NULL, '2014-10-08 16:23:37', '2014-10-08 16:23:37'),
  (6, '蛤蛤', '**', 1, 1, NULL, '2014-10-08 16:24:03', '2014-10-08 16:24:03'),
  (7, '汽狗', '**', 1, 1, NULL, '2014-10-08 16:24:48', '2014-10-08 16:29:11'),
  (8, '测试1', '**', 1, 1, '2014-10-08 16:29:05', '2014-10-08 16:25:03', '2014-10-08 16:29:05');


/*----------------------------------------------------------
| 测试 comment 数据库
----------------------------------------------------------*/
CREATE TABLE `comments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `app_id` int(11) NOT NULL,
  `title` varchar(128) COLLATE utf8_unicode_ci NOT NULL COMMENT '游戏名',
  `pack` varchar(128) COLLATE utf8_unicode_ci NOT NULL COMMENT '包名',
  `imei` varchar(32) COLLATE utf8_unicode_ci NOT NULL COMMENT '用户手机IMEI',
  `type` varchar(32) COLLATE utf8_unicode_ci NOT NULL COMMENT '用户机型',
  `ip` varchar(16) COLLATE utf8_unicode_ci NOT NULL COMMENT '用户IP',
  `content` varchar(32) COLLATE utf8_unicode_ci NOT NULL COMMENT '内容',
  `rating` tinyint(4) NOT NULL COMMENT '评分',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `comments` (`id`, `app_id`, `title`, `pack`, `imei`, `type`, `ip`, `content`, `rating`, `deleted_at`, `created_at`, `updated_at`)
VALUES
  (1, 1, '植物大战僵尸啦', 'xxxooo.com.zhiwu', 'ABSDEDEDCHAYFSS', 'htc', '127.0.0.1', '非常老行', 5, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
  (2, 1, '植物大战僵尸啦', 'xxxooo.com.zhiwu', 'ABSDEDEDCHAYFSS', 'htc', '127.0.0.1', '非常老行', 5, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
  (3, 1, '植物大战僵尸啦', 'xxxooo.com.zhiwu', 'ABSDEDEDCHAYFSS', 'htc', '127.0.0.1', '非常老行', 5, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
  (4, 1, '植物大战僵尸啦', 'xxxooo.com.zhiwu', 'ABSDEDEDCHAYFSS', 'htc', '127.0.0.1', '非常老行', 5, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
  (5, 1, '植物大战僵尸啦', 'xxxooo.com.zhiwu', 'ABSDEDEDCHAYFSS', 'htc', '127.0.0.1', '非常老行', 5, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
  (6, 1, '植物大战僵尸啦', 'xxxooo.com.zhiwu', 'ABSDEDEDCHAYFSS', 'htc', '127.0.0.1', '非常老行', 5, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00');



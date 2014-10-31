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
  `status` enum('publish','draft','pending','notpass','stock','unstock') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'publish' COMMENT '数据状态',
  `is_verify` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no' COMMENT '是否安全认证',
  `has_ad` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no' COMMENT '是否无广告',
  `stocked_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '上架时间',
  `unstocked_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '下架时间',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/* 测试上架 */
INSERT INTO `apps` (`id`, `icon`, `title`, `pack`, `size`, `size_int`, `version`, `author`, `summary`, `images`, `changes`, `reason`, `download_counts`, `download_manual`, `download_link`, `operator`, `os`, `os_version`, `sort`, `status`, `is_verify`, `has_ad`, `stocked_at`, `unstocked_at`, `deleted_at`, `created_at`, `updated_at`)
VALUES
    (100,'/icons/0/4/0420dd2a485e9978e78248c6d8aea840.png','上架游戏A君','a.a.a','1 GB',1048576,'3.0.0','','','','','',100,'','/apks/5/8/58c0c78ab05fbfc518136c50e255ca16.apk',0,'','',99,'stock','no','no','2014-09-03 00:00:00','0000-00-00 00:00:00',NULL,'2014-09-03 10:00:00','2014-09-23 08:04:46'),
    (101,'/icons/0/4/0420dd2a485e9978e78248c6d8aea840.png','填充游戏君','a.a.a','1 GB',104857,'3.0.0','','','','','',101,'','/apks/5/8/58c0c78ab05fbfc518136c50e255ca16.apk',0,'','',99,'stock','no','no','2014-09-01 00:00:00','0000-00-00 00:00:00',NULL,'2014-09-03 10:00:00','2014-09-23 08:04:46'),
    (102,'/icons/0/4/0420dd2a485e9978e78248c6d8aea840.png','填充游戏君','a.a.a','1 GB',104857,'3.0.0','','','','','',101,'','/apks/5/8/58c0c78ab05fbfc518136c50e255ca16.apk',0,'','',99,'stock','no','no','2014-09-01 00:00:00','0000-00-00 00:00:00',NULL,'2014-09-03 10:00:00','2014-09-23 08:04:46'),
    (103,'/icons/0/4/0420dd2a485e9978e78248c6d8aea840.png','填充游戏君','a.a.a','1 GB',104857,'3.0.0','','','','','',101,'','/apks/5/8/58c0c78ab05fbfc518136c50e255ca16.apk',0,'','',99,'stock','no','no','2014-09-01 00:00:00','0000-00-00 00:00:00',NULL,'2014-09-03 10:00:00','2014-09-23 08:04:46'),
    (104,'/icons/0/4/0420dd2a485e9978e78248c6d8aea840.png','填充游戏君','a.a.a','1 GB',104857,'3.0.0','','','','','',101,'','/apks/5/8/58c0c78ab05fbfc518136c50e255ca16.apk',0,'','',99,'stock','no','no','2014-09-01 00:00:00','0000-00-00 00:00:00',NULL,'2014-09-03 10:00:00','2014-09-23 08:04:46'),
    (105,'/icons/0/4/0420dd2a485e9978e78248c6d8aea840.png','填充游戏君','a.a.a','1 GB',104857,'3.0.0','','','','','',101,'','/apks/5/8/58c0c78ab05fbfc518136c50e255ca16.apk',0,'','',99,'stock','no','no','2014-09-01 00:00:00','0000-00-00 00:00:00',NULL,'2014-09-03 10:00:00','2014-09-23 08:04:46'),
    (106,'/icons/0/4/0420dd2a485e9978e78248c6d8aea840.png','填充游戏君','a.a.a','1 GB',104857,'3.0.0','','','','','',101,'','/apks/5/8/58c0c78ab05fbfc518136c50e255ca16.apk',0,'','',99,'stock','no','no','2014-09-01 00:00:00','0000-00-00 00:00:00',NULL,'2014-09-03 10:00:00','2014-09-23 08:04:46'),
    (107,'/icons/0/4/0420dd2a485e9978e78248c6d8aea840.png','填充游戏君','a.a.a','1 GB',104857,'3.0.0','','','','','',101,'','/apks/5/8/58c0c78ab05fbfc518136c50e255ca16.apk',0,'','',99,'stock','no','no','2014-09-01 00:00:00','0000-00-00 00:00:00',NULL,'2014-09-03 10:00:00','2014-09-23 08:04:46'),
    (108,'/icons/0/4/0420dd2a485e9978e78248c6d8aea840.png','填充游戏君','a.a.a','1 GB',104857,'3.0.0','','','','','',101,'','/apks/5/8/58c0c78ab05fbfc518136c50e255ca16.apk',0,'','',99,'stock','no','no','2014-09-01 00:00:00','0000-00-00 00:00:00',NULL,'2014-09-03 10:00:00','2014-09-23 08:04:46'),
    (109,'/icons/0/4/0420dd2a485e9978e78248c6d8aea840.png','填充游戏君','a.a.a','1 GB',104857,'3.0.0','','','','','',101,'','/apks/5/8/58c0c78ab05fbfc518136c50e255ca16.apk',0,'','',99,'stock','no','no','2014-09-01 00:00:00','0000-00-00 00:00:00',NULL,'2014-09-03 10:00:00','2014-09-23 08:04:46'),
    (110,'/icons/0/4/0420dd2a485e9978e78248c6d8aea840.png','填充游戏君','a.a.a','1 GB',104857,'3.0.0','','','','','',101,'','/apks/5/8/58c0c78ab05fbfc518136c50e255ca16.apk',0,'','',99,'stock','no','no','2014-09-01 00:00:00','0000-00-00 00:00:00',NULL,'2014-09-03 10:00:00','2014-09-23 08:04:46'),
    (111,'/icons/0/4/0420dd2a485e9978e78248c6d8aea840.png','填充游戏君','a.a.a','1 GB',104857,'3.0.0','','','','','',101,'','/apks/5/8/58c0c78ab05fbfc518136c50e255ca16.apk',0,'','',99,'stock','no','no','2014-09-01 00:00:00','0000-00-00 00:00:00',NULL,'2014-09-03 10:00:00','2014-09-23 08:04:46'),
    (112,'/icons/0/4/0420dd2a485e9978e78248c6d8aea840.png','填充游戏君','a.a.a','1 GB',104857,'3.0.0','','','','','',101,'','/apks/5/8/58c0c78ab05fbfc518136c50e255ca16.apk',0,'','',99,'stock','no','no','2014-09-01 00:00:00','0000-00-00 00:00:00',NULL,'2014-09-03 10:00:00','2014-09-23 08:04:46'),
    (113,'/icons/0/4/0420dd2a485e9978e78248c6d8aea840.png','填充游戏君','a.a.a','1 GB',104857,'3.0.0','','','','','',101,'','/apks/5/8/58c0c78ab05fbfc518136c50e255ca16.apk',0,'','',99,'stock','no','no','2014-09-01 00:00:00','0000-00-00 00:00:00',NULL,'2014-09-03 10:00:00','2014-09-23 08:04:46'),
    (114,'/icons/0/4/0420dd2a485e9978e78248c6d8aea840.png','填充游戏君','a.a.a','1 GB',104857,'3.0.0','','','','','',101,'','/apks/5/8/58c0c78ab05fbfc518136c50e255ca16.apk',0,'','',99,'stock','no','no','2014-09-01 00:00:00','0000-00-00 00:00:00',NULL,'2014-09-03 10:00:00','2014-09-23 08:04:46'),
    (115,'/icons/0/4/0420dd2a485e9978e78248c6d8aea840.png','填充游戏君','a.a.a','1 GB',104857,'3.0.0','','','','','',101,'','/apks/5/8/58c0c78ab05fbfc518136c50e255ca16.apk',0,'','',99,'stock','no','no','2014-09-01 00:00:00','0000-00-00 00:00:00',NULL,'2014-09-03 10:00:00','2014-09-23 08:04:46'),
    (116,'/icons/0/4/0420dd2a485e9978e78248c6d8aea840.png','填充游戏君','a.a.a','1 GB',104857,'3.0.0','','','','','',101,'','/apks/5/8/58c0c78ab05fbfc518136c50e255ca16.apk',0,'','',99,'stock','no','no','2014-09-01 00:00:00','0000-00-00 00:00:00',NULL,'2014-09-03 10:00:00','2014-09-23 08:04:46'),
    (117,'/icons/0/4/0420dd2a485e9978e78248c6d8aea840.png','填充游戏君','a.a.a','1 GB',104857,'3.0.0','','','','','',101,'','/apks/5/8/58c0c78ab05fbfc518136c50e255ca16.apk',0,'','',99,'stock','no','no','2014-09-01 00:00:00','0000-00-00 00:00:00',NULL,'2014-09-03 10:00:00','2014-09-23 08:04:46'),
    (118,'/icons/0/4/0420dd2a485e9978e78248c6d8aea840.png','填充游戏君','a.a.a','1 GB',104857,'3.0.0','','','','','',101,'','/apks/5/8/58c0c78ab05fbfc518136c50e255ca16.apk',0,'','',99,'stock','no','no','2014-09-01 00:00:00','0000-00-00 00:00:00',NULL,'2014-09-03 10:00:00','2014-09-23 08:04:46'),
    (119,'/icons/0/4/0420dd2a485e9978e78248c6d8aea840.png','填充游戏君','a.a.a','1 GB',104857,'3.0.0','','','','','',101,'','/apks/5/8/58c0c78ab05fbfc518136c50e255ca16.apk',0,'','',99,'stock','no','no','2014-09-01 00:00:00','0000-00-00 00:00:00',NULL,'2014-09-03 10:00:00','2014-09-23 08:04:46'),
    (120,'/icons/0/4/0420dd2a485e9978e78248c6d8aea840.png','上架游戏B君','b.b.b','1 MB',1024,'5.0.0','','','','','',101,'','/apks/5/8/58c0c78ab05fbfc518136c50e255ca16.apk',0,'','',99,'stock','no','no','2014-09-01 00:00:00','0000-00-00 00:00:00',NULL,'2014-09-03 10:00:00','2014-09-23 08:04:46'),
    (121,'/icons/0/4/0420dd2a485e9978e78248c6d8aea840.png','上架游戏C君','c.c.c','2 GB',2097152,'5.0.0','','','','','',99,'','/apks/5/8/58c0c78ab05fbfc518136c50e255ca16.apk',0,'','',99,'stock','no','no','2014-09-05 00:00:00','0000-00-00 00:00:00',NULL,'2014-09-03 10:00:00','2014-09-23 08:04:46'),
    (3,'/icons/0/4/0420dd2a485e9978e78248c6d8aea840.png','上架游戏C君','c.c.c','2 GB',2097152,'5.0.0','','','','','',99,'','/apks/5/8/58c0c78ab05fbfc518136c50e255ca16.apk',0,'','',99,'stock','no','no','2014-09-05 00:00:00','0000-00-00 00:00:00',NULL,'2014-09-03 10:00:00','2014-09-23 08:04:46');



/* 测试草稿 */
INSERT INTO `apps` (`id`, `icon`, `title`, `pack`, `size`, `size_int`, `version`, `author`, `summary`, `images`, `changes`, `reason`, `download_counts`, `download_manual`, `download_link`, `operator`, `os`, `os_version`, `sort`, `status`, `is_verify`, `has_ad`, `stocked_at`, `unstocked_at`, `deleted_at`, `created_at`, `updated_at`)
VALUES
    (22,'/icons/0/4/0420dd2a485e9978e78248c6d8aea840.png','上传游戏A君','','27 KB',27,'1.0.2','','','','','',0,'','/apks/5/8/58c0c78ab05fbfc518136c50e255ca16.apk',0,'','',99,'publish','no','no','0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'2014-09-03 10:00:00','2014-09-23 08:04:46'),
    (21,'/icons/6/8/68745070802f9b8addf6db640d86eeff.png','上传游戏B君','','157 KB',157,'1.0','','','','','',0,'','/apks/3/9/3934bc5f9504a26baf546483b595f45a.apk',0,'','',98,'publish','no','no','0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'2014-09-01 10:00:00','2014-09-23 09:24:02'),
    (20,'/icons/f/e/febeb565db27cf439b414798fdc7a5a6.png','填充游戏君','','350 KB',350,'1.50','','','','','',0,'','/apks/a/9/a94fb9264643673fa6b54fb996cc0d70.apk',0,'','',97,'publish','no','no','0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'2014-09-23 09:24:46','2014-09-24 02:35:37'),
    (19,'/icons/f/e/febeb565db27cf439b414798fdc7a5a6.png','可怜软件A君','','350 KB',350,'1.50','','','','','',0,'','/apks/a/9/a94fb9264643673fa6b54fb996cc0d70.apk',0,'','',96,'publish','no','no','0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'2014-09-02 10:00:00','2014-09-24 02:35:37'),
    (18,'/icons/f/e/febeb565db27cf439b414798fdc7a5a6.png','填充游戏君','','350 KB',350,'1.50','','','','','',0,'','/apks/a/9/a94fb9264643673fa6b54fb996cc0d70.apk',0,'','',95,'publish','no','no','0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'2014-09-23 09:24:46','2014-09-24 02:35:37'),
    (17,'/icons/f/e/febeb565db27cf439b414798fdc7a5a6.png','填充游戏君','','350 KB',350,'1.50','','','','','',0,'','/apks/a/9/a94fb9264643673fa6b54fb996cc0d70.apk',0,'','',94,'publish','no','no','0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'2014-09-23 09:24:46','2014-09-24 02:35:37'),
    (16,'/icons/f/e/febeb565db27cf439b414798fdc7a5a6.png','填充游戏君','','350 KB',350,'1.50','','','','','',0,'','/apks/a/9/a94fb9264643673fa6b54fb996cc0d70.apk',0,'','',93,'publish','no','no','0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'2014-09-23 09:24:46','2014-09-24 02:35:37'),
    (15,'/icons/f/e/febeb565db27cf439b414798fdc7a5a6.png','上传游戏D君','','350 KB',350,'1.50','','','','','',0,'','/apks/a/9/a94fb9264643673fa6b54fb996cc0d70.apk',0,'','',92,'publish','no','no','0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'2014-09-23 09:24:46','2014-09-24 02:35:37'),
    (14,'/icons/f/e/febeb565db27cf439b414798fdc7a5a6.png','草稿游戏A君','','350 KB',350,'1.50','','','','','',0,'','/apks/a/9/a94fb9264643673fa6b54fb996cc0d70.apk',0,'','',91,'draft','no','no','0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'2014-09-23 09:24:46','2014-09-24 02:35:37'),
    (13,'/icons/f/e/febeb565db27cf439b414798fdc7a5a6.png','填充游戏君','','350 KB',350,'1.50','','','','','',0,'','/apks/a/9/a94fb9264643673fa6b54fb996cc0d70.apk',0,'','',90,'publish','no','no','0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'2014-09-23 09:24:46','2014-09-24 02:35:37'),
    (12,'/icons/f/e/febeb565db27cf439b414798fdc7a5a6.png','填充游戏君','','350 KB',350,'1.50','','','','','',0,'','/apks/a/9/a94fb9264643673fa6b54fb996cc0d70.apk',0,'','',89,'publish','no','no','0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'2014-09-23 09:24:46','2014-09-24 02:35:37'),
    (11,'/icons/f/e/febeb565db27cf439b414798fdc7a5a6.png','填充游戏君','','350 KB',350,'1.50','','','','','',0,'','/apks/a/9/a94fb9264643673fa6b54fb996cc0d70.apk',0,'','',87,'publish','no','no','0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'2014-09-23 09:24:46','2014-09-24 02:35:37'),
    (10,'/icons/f/e/febeb565db27cf439b414798fdc7a5a6.png','填充游戏君','','350 KB',350,'1.50','','','','','',0,'','/apks/a/9/a94fb9264643673fa6b54fb996cc0d70.apk',0,'','',86,'publish','no','no','0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'2014-09-23 09:24:46','2014-09-24 02:35:37'),
    (9,'/icons/f/e/febeb565db27cf439b414798fdc7a5a6.png','填充游戏君','','350 KB',350,'1.50','','','','','',0,'','/apks/a/9/a94fb9264643673fa6b54fb996cc0d70.apk',0,'','',85,'publish','no','no','0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'2014-09-23 09:24:46','2014-09-24 02:35:37'),
    (8,'/icons/f/e/febeb565db27cf439b414798fdc7a5a6.png','填充游戏君','','350 KB',350,'1.50','','','','','',0,'','/apks/a/9/a94fb9264643673fa6b54fb996cc0d70.apk',0,'','',84,'publish','no','no','0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'2014-09-23 09:24:46','2014-09-24 02:35:37'),
    (7,'/icons/f/e/febeb565db27cf439b414798fdc7a5a6.png','填充游戏君','','350 KB',350,'1.50','','','','','',0,'','/apks/a/9/a94fb9264643673fa6b54fb996cc0d70.apk',0,'','',83,'publish','no','no','0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'2014-09-23 09:24:46','2014-09-24 02:35:37'),
    (6,'/icons/f/e/febeb565db27cf439b414798fdc7a5a6.png','填充游戏君','','350 KB',350,'1.50','','','','','',0,'','/apks/a/9/a94fb9264643673fa6b54fb996cc0d70.apk',0,'','',82,'publish','no','no','0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'2014-09-23 09:24:46','2014-09-24 02:35:37'),
    (5,'/icons/f/e/febeb565db27cf439b414798fdc7a5a6.png','填充游戏君','','350 KB',350,'1.50','','','','','',0,'','/apks/a/9/a94fb9264643673fa6b54fb996cc0d70.apk',0,'','',81,'publish','no','no','0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'2014-09-23 09:24:46','2014-09-24 02:35:37'),
    (4,'/icons/f/e/febeb565db27cf439b414798fdc7a5a6.png','填充游戏君','','350 KB',350,'1.50','','','','','',0,'','/apks/a/9/a94fb9264643673fa6b54fb996cc0d70.apk',0,'','',80,'publish','no','no','0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'2014-09-23 09:24:46','2014-09-24 02:35:37'),
    (2,'/icons/f/e/febeb565db27cf439b414798fdc7a5a6.png','分页游戏A君','','350 KB',350,'1.50','','','','','',0,'','/apks/a/9/a94fb9264643673fa6b54fb996cc0d70.apk',0,'','',78,'publish','no','no','0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'2014-09-23 09:24:46','2014-09-24 02:35:37'),
    (1,'/icons/f/e/febeb565db27cf439b414798fdc7a5a6.png','分页游戏B君','','350 KB',350,'1.50','','','','','',0,'','/apks/a/9/a94fb9264643673fa6b54fb996cc0d70.apk',0,'','',77,'publish','no','no','0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'2014-09-23 09:24:46','2014-09-24 02:35:37'),
    (444,'/icons/f/e/febeb565db27cf439b414798fdc7a5a6.png','删除游戏A君','','350 KB',350,'1.50','','','','','',0,'','/apks/a/9/a94fb9264643673fa6b54fb996cc0d70.apk',0,'','',76,'publish','no','no','0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'2014-09-23 09:24:46','2014-09-24 02:35:37');

/* 测试待审核 */
INSERT INTO `apps` (`id`, `icon`, `title`, `pack`, `size`, `size_int`, `version`, `author`, `summary`, `images`, `changes`, `reason`, `download_counts`, `download_manual`, `download_link`, `operator`, `os`, `os_version`, `sort`, `status`, `is_verify`, `has_ad`, `stocked_at`, `unstocked_at`, `deleted_at`, `created_at`, `updated_at`)
VALUES
    (30,'/icons/0/4/0420dd2a485e9978e78248c6d8aea840.png','待审游戏A君','','27 KB',27,'1.0.2','','','','','',0,'','/apks/5/8/58c0c78ab05fbfc518136c50e255ca16.apk',0,'','',99,'pending','no','no','0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'2014-09-03 10:00:00','2014-09-23 08:04:46'),
    (31,'/icons/6/8/68745070802f9b8addf6db640d86eeff.png','待审游戏B君','','157 KB',157,'1.0','','','','','',0,'','/apks/3/9/3934bc5f9504a26baf546483b595f45a.apk',0,'','',98,'pending','no','no','0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'2014-09-01 10:00:00','2014-09-23 09:24:02'),
    (32,'/icons/0/4/0420dd2a485e9978e78248c6d8aea840.png','待审游戏C君','','27 KB',27,'1.0.2','','','','','',0,'','/apks/5/8/58c0c78ab05fbfc518136c50e255ca16.apk',0,'','',99,'pending','no','no','0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'2014-09-03 10:00:00','2014-09-23 08:04:46'),
    (33,'/icons/6/8/68745070802f9b8addf6db640d86eeff.png','待审游戏D君','','157 KB',157,'1.0','','','','','',0,'','/apks/3/9/3934bc5f9504a26baf546483b595f45a.apk',0,'','',98,'pending','no','no','0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'2014-09-01 10:00:00','2014-09-23 09:24:02'),
    (34,'/icons/0/4/0420dd2a485e9978e78248c6d8aea840.png','待审游戏E君','','27 KB',27,'1.0.2','','','','','',0,'','/apks/5/8/58c0c78ab05fbfc518136c50e255ca16.apk',0,'','',99,'pending','no','no','0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'2014-09-03 10:00:00','2014-09-23 08:04:46'),
    (35,'/icons/6/8/68745070802f9b8addf6db640d86eeff.png','待审游戏F君','','157 KB',157,'1.0','','','','','',0,'','/apks/3/9/3934bc5f9504a26baf546483b595f45a.apk',0,'','',98,'pending','no','no','0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'2014-09-01 10:00:00','2014-09-23 09:24:02'),
    (36,'/icons/0/4/0420dd2a485e9978e78248c6d8aea840.png','待审游戏G君','','27 KB',27,'1.0.2','','','','','',0,'','/apks/5/8/58c0c78ab05fbfc518136c50e255ca16.apk',0,'','',99,'pending','no','no','0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'2014-09-03 10:00:00','2014-09-23 08:04:46'),
    (37,'/icons/6/8/68745070802f9b8addf6db640d86eeff.png','待审游戏H君','','157 KB',157,'1.0','','','','','',0,'','/apks/3/9/3934bc5f9504a26baf546483b595f45a.apk',0,'','',98,'pending','no','no','0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'2014-09-01 10:00:00','2014-09-23 09:24:02');

/* 测试审核不通过 */
INSERT INTO `apps` (`id`, `icon`, `title`, `pack`, `size`, `size_int`, `version`, `author`, `summary`, `images`, `changes`, `reason`, `download_counts`, `download_manual`, `download_link`, `operator`, `os`, `os_version`, `sort`, `status`, `is_verify`, `has_ad`, `stocked_at`, `unstocked_at`, `deleted_at`, `created_at`, `updated_at`)
VALUES
    (40,'/icons/0/4/0420dd2a485e9978e78248c6d8aea840.png','不通过游戏A君','','27 KB',27,'1.0.2','','','','','',0,'','/apks/5/8/58c0c78ab05fbfc518136c50e255ca16.apk',0,'','',99,'notpass','no','no','0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'2014-09-03 10:00:00','2014-09-23 08:04:46');

/* 测试下架 */
INSERT INTO `apps` (`id`, `icon`, `title`, `pack`, `size`, `size_int`, `version`, `author`, `summary`, `images`, `changes`, `reason`, `download_counts`, `download_manual`, `download_link`, `operator`, `os`, `os_version`, `sort`, `status`, `is_verify`, `has_ad`, `stocked_at`, `unstocked_at`, `deleted_at`, `created_at`, `updated_at`)
VALUES
    (50,'/icons/0/4/0420dd2a485e9978e78248c6d8aea840.png','下架游戏A君','','27 KB',27,'1.0.2','','','','','',0,'','/apks/5/8/58c0c78ab05fbfc518136c50e255ca16.apk',0,'','',99,'unstock','no','no','0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'2014-09-03 10:00:00','2014-09-23 08:04:46');

/*----------------------------------------------------------
| 测试 rating 数据库
----------------------------------------------------------*/
DROP TABLE IF EXISTS `ratings`;

CREATE TABLE `ratings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `app_id` int(11) NOT NULL,
  `title` varchar(128) COLLATE utf8_unicode_ci NOT NULL COMMENT '游戏名',
  `pack` varchar(128) COLLATE utf8_unicode_ci NOT NULL COMMENT '包名',
  `total` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '总评分',
  `counts` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '评分次数',
  `avg` decimal(3,2) NOT NULL DEFAULT '0.00' COMMENT '平均分',
  `manual` decimal(3,2) NOT NULL DEFAULT '0.00' COMMENT '干预后得分',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

insert into ratings (app_id, title, pack) select id as appid, title, pack from apps;

/*----------------------------------------------------------
| 测试 cats 数据库
----------------------------------------------------------*/
DROP TABLE IF EXISTS `cats`;

CREATE TABLE `cats` (
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

INSERT INTO `cats` (`id`, `title`, `parent_id`, `search_total`, `sort`, `deleted_at`, `created_at`, `updated_at`)
VALUES
  (1, '休闲益智', 0, 0, 0, NULL, '2014-09-26 02:42:10', '2014-09-26 02:42:10'),
  (2, '角色扮演', 0, 0, 0, NULL, '2014-09-26 02:42:10', '2014-09-26 02:42:10'),
  (24, '单机游戏', 0, 0, 0, NULL, '2014-09-26 02:42:10', '2014-09-26 02:42:10'),
  (25, '横版游戏', 0, 0, 0, NULL, '2014-09-26 02:42:24', '2014-09-26 02:42:24'),
  (26, '飞升游戏', 0, 0, 0, NULL, '2014-09-26 02:42:34', '2014-09-26 02:42:34'),
  (27, '来点东西', 0, 0, 0, NULL, '2014-09-26 05:35:36', '2014-09-26 05:35:36');

INSERT INTO `cats` (`id`, `title`, `parent_id`, `search_total`, `sort`, `deleted_at`, `created_at`, `updated_at`)
VALUES
  (3, '围棋', 1, 0, 0, NULL, '2014-09-26 02:42:10', '2014-09-26 02:42:10'),
  (4, '象棋', 1, 0, 0, NULL, '2014-09-26 02:42:10', '2014-09-26 02:42:10');

/*----------------------------------------------------------
| 测试 app_cats 数据库
----------------------------------------------------------*/
DROP TABLE IF EXISTS `app_cats`;

CREATE TABLE `app_cats` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `app_id` int(10) unsigned NOT NULL COMMENT '游戏ID',
  `cat_id` int(10) unsigned NOT NULL COMMENT '分类ID',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `app_cats` (`id`, `app_id`, `cat_id`, `created_at`, `updated_at`) VALUES
  (1,22,1,'2014-09-29 09:22:39','2014-09-29 09:22:39'),
  (2,21,2,'2014-09-29 09:22:39','2014-09-29 09:22:39');


/*----------------------------------------------------------
| 测试 cate_ads 数据库
----------------------------------------------------------*/
DROP TABLE IF EXISTS `cate_ads`;

CREATE TABLE `cat_ads` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cat_id` int(10) unsigned NOT NULL COMMENT '分类ID',
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '分类名',
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '分类图片',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


insert into cat_ads (cat_id, title) select id , title from cats where deleted_at is null and parent_id = 0;

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


INSERT INTO `keywords` (`id`, `word`, `search_total`, `is_slide`, `creator`, `operator`, `deleted_at`, `created_at`, `updated_at`)
VALUES
  (1, '无聊', 0, 'yes', 0, 1, NULL, '0000-00-00 00:00:00', '2014-09-19 07:55:20'),
  (3, '飞机', 0, 'no', 0, 1, NULL, '0000-00-00 00:00:00', '2014-09-19 07:55:55'),
  (4, '坦克', 0, 'no', 0, 1, NULL, '0000-00-00 00:00:00', '2014-09-19 07:59:07'),
  (5, '辽宁号', 0, 'no', 0, 0, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
  (6, '我是测试', 0, 'no', 1, 1, NULL, '2014-09-18 17:31:29', '2014-09-18 17:31:29'),
  (7, '我是测试', 0, 'no', 1, 1, NULL, '2014-09-18 17:31:42', '2014-09-18 17:31:42'),
  (8, '我是测试', 0, 'no', 1, 1, NULL, '2014-09-18 17:31:43', '2014-09-18 17:31:43');


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
  `is_stock` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no' COMMENT '是否上架',
  `is_top` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no' COMMENT '是否置顶',
  `stocked_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '上架时间',
  `unstocked_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '下架时间',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `ads` (`app_id`, `title`, `location`, `image`, `word`, `sort`, `type`, `is_stock`, `is_top`, `stocked_at`, `unstocked_at`, `deleted_at`, `created_at`, `updated_at`)
VALUES
  (3, '一个', 'search', '/ads/6/f/6f46c1a33dbd27e06d7601a771de004a.jpg', '', 0, 'app', 'no', 'yes', '2014-10-24 00:00:00', '2014-10-25 00:00:00', NULL, '2014-10-24 14:05:48', '2014-10-27 16:02:26'),
  (3, '一个', 'search', '/ads/e/d/ed8d2ff2af28db3a64ff1246698e134a.jpg', '', 0, 'app', 'yes', 'yes', '2014-10-27 00:00:00', '2014-10-28 00:00:00', NULL, '2014-10-27 16:02:58', '2014-10-27 16:32:58'),
  (2, '问股', 'hotdown', '/ads/4/7/4730bbb7ad5c4cbeda2aef3fabc245a7.jpg', '', 0, 'app', 'yes', 'no', '2014-10-27 00:00:00', '2014-10-28 00:00:00', NULL, '2014-10-27 17:06:39', '2014-10-27 19:27:23'),
  (3, '一个', 'new', '/ads/4/5/453b5dd5f5e387623ee9fa0d5aab35ca.jpg', '', 0, 'app', 'yes', 'no', '2014-10-26 00:00:00', '2014-10-29 00:00:00', NULL, '2014-10-27 18:30:50', '2014-10-27 18:30:50'),
  (3, '一个', 'new', '/ads/4/5/453b5dd5f5e387623ee9fa0d5aab35ca.jpg', '', 0, 'app', 'yes', 'no', '2014-10-26 00:00:00', '2014-10-29 00:00:00', NULL, '2014-10-27 18:30:50', '2014-10-27 18:30:50'),
  (3, '一个', 'hotdown', '/ads/e/d/ed8d2ff2af28db3a64ff1246698e134a.jpg', '', 0, 'app', 'yes', 'yes', '2014-10-27 00:00:00', '2014-10-28 00:00:00', NULL, '2014-10-27 16:02:58', '2014-10-27 16:32:58'),
  (3, '一个', 'search', '/ads/e/d/ed8d2ff2af28db3a64ff1246698e134a.jpg', '', 0, 'app', 'yes', 'yes', '2014-10-27 00:00:00', '2014-10-28 00:00:00', NULL, '2014-10-27 16:02:58', '2014-10-27 16:32:58'),
  (3, '一个', 'search', '/ads/e/d/ed8d2ff2af28db3a64ff1246698e134a.jpg', '', 0, 'app', 'yes', 'yes', '2014-10-27 00:00:00', '2014-10-28 00:00:00', NULL, '2014-10-27 16:02:58', '2014-10-27 16:32:58'),
  (3, '一个', 'search', '/ads/e/d/ed8d2ff2af28db3a64ff1246698e134a.jpg', '', 0, 'app', 'yes', 'yes', '2014-10-27 00:00:00', '2014-10-28 00:00:00', NULL, '2014-10-27 16:02:58', '2014-10-27 16:32:58'),
  (3, '一个', 'search', '/ads/e/d/ed8d2ff2af28db3a64ff1246698e134a.jpg', '', 0, 'app', 'yes', 'yes', '2014-10-27 00:00:00', '2014-10-28 00:00:00', NULL, '2014-10-27 16:02:58', '2014-10-27 16:32:58');

INSERT INTO `ads` (`app_id`, `title`, `location`, `image`, `word`, `sort`, `type`, `is_stock`, `is_top`, `stocked_at`, `unstocked_at`, `deleted_at`, `created_at`, `updated_at`)
VALUES
  (2, '问股', 'hotdown', '/ads/d/3/d300dc2509b84f25b539d74b06dd39c0.jpg', '', 0, 'index', 'yes', 'yes', '2014-10-28 00:00:00', '2014-10-29 00:00:00', NULL, '2014-10-27 19:01:52', '2014-10-27 19:02:24'),
  (3, '一个', 'hotdown', '/ads/9/a/9a11918ee4e8d99529aa6585fab7d22f.jpg', '', 0, 'index', 'yes', 'no', '2014-10-29 00:00:00', '2014-10-31 00:00:00', NULL, '2014-10-27 19:34:22', '2014-10-27 19:34:22'),
  (3, '一个', 'slide', '/ads/8/b/8ba686fc9027bece8b5a4c135bcbc9bf.jpg', '', 0, 'index', 'yes', 'yes', '2014-10-29 00:00:00', '2014-10-31 00:00:00', NULL, '2014-10-31 11:19:32', '2014-10-31 11:19:32'),
  (2, 'TTPod', 'new', '/ads/2/9/29d8bf8257d706ed9b613419a72e2d1b.jpg', '', 0, 'index', 'yes', 'yes', '2014-10-31 00:00:00', '2014-11-02 00:00:00', NULL, '2014-10-31 11:20:04', '2014-10-31 11:20:04'),
  (3, '一个', 'hotdown', '/ads/9/a/9a11918ee4e8d99529aa6585fab7d22f.jpg', '', 0, 'index', 'yes', 'no', '2014-10-29 00:00:00', '2014-10-31 00:00:00', NULL, '2014-10-27 19:34:22', '2014-10-27 19:34:22'),
  (3, '一个', 'slide', '/ads/8/b/8ba686fc9027bece8b5a4c135bcbc9bf.jpg', '', 0, 'index', 'yes', 'yes', '2014-10-29 00:00:00', '2014-10-31 00:00:00', NULL, '2014-10-31 11:19:32', '2014-10-31 11:19:32'),
  (2, 'TTPod', 'new', '/ads/2/9/29d8bf8257d706ed9b613419a72e2d1b.jpg', '', 0, 'index', 'yes', 'yes', '2014-10-31 00:00:00', '2014-11-02 00:00:00', NULL, '2014-10-31 11:20:04', '2014-10-31 11:20:04'),
  (3, '一个', 'hotdown', '/ads/9/a/9a11918ee4e8d99529aa6585fab7d22f.jpg', '', 0, 'index', 'yes', 'no', '2014-10-29 00:00:00', '2014-10-31 00:00:00', NULL, '2014-10-27 19:34:22', '2014-10-27 19:34:22'),
  (2, 'TTPod', 'new', '/ads/2/9/29d8bf8257d706ed9b613419a72e2d1b.jpg', '', 0, 'index', 'yes', 'yes', '2014-10-31 00:00:00', '2014-11-02 00:00:00', NULL, '2014-10-31 11:20:04', '2014-10-31 11:20:04'),
  (3, '一个', 'hotdown', '/ads/9/a/9a11918ee4e8d99529aa6585fab7d22f.jpg', '', 0, 'index', 'yes', 'no', '2014-10-29 00:00:00', '2014-10-31 00:00:00', NULL, '2014-10-27 19:34:22', '2014-10-27 19:34:22'),
  (2, 'TTPod', 'new', '/ads/2/9/29d8bf8257d706ed9b613419a72e2d1b.jpg', '', 0, 'index', 'yes', 'yes', '2014-10-31 00:00:00', '2014-11-02 00:00:00', NULL, '2014-10-31 11:20:04', '2014-10-31 11:20:04'),
  (3, '一个', 'hotdown', '/ads/9/a/9a11918ee4e8d99529aa6585fab7d22f.jpg', '', 0, 'index', 'yes', 'no', '2014-10-29 00:00:00', '2014-10-31 00:00:00', NULL, '2014-10-27 19:34:22', '2014-10-27 19:34:22'),
  (2, 'TTPod', 'new', '/ads/2/9/29d8bf8257d706ed9b613419a72e2d1b.jpg', '', 0, 'index', 'yes', 'yes', '2014-10-31 00:00:00', '2014-11-02 00:00:00', NULL, '2014-10-31 11:20:04', '2014-10-31 11:20:04'),
  (2, 'TTPod', 'new', '/ads/2/9/29d8bf8257d706ed9b613419a72e2d1b.jpg', '', 0, 'index', 'yes', 'yes', '2014-10-31 00:00:00', '2014-11-02 00:00:00', NULL, '2014-10-31 11:20:04', '2014-10-31 11:20:04'),
  (2, 'TTPod', 'new', '/ads/2/9/29d8bf8257d706ed9b613419a72e2d1b.jpg', '', 0, 'index', 'yes', 'yes', '2014-10-31 00:00:00', '2014-11-02 00:00:00', NULL, '2014-10-31 11:20:04', '2014-10-31 11:20:04'),
  (2, 'TTPod', 'new', '/ads/2/9/29d8bf8257d706ed9b613419a72e2d1b.jpg', '', 0, 'index', 'yes', 'yes', '2014-10-31 00:00:00', '2014-11-02 00:00:00', NULL, '2014-10-31 11:20:04', '2014-10-31 11:20:04'),
  (2, 'TTPod', 'new', '/ads/2/9/29d8bf8257d706ed9b613419a72e2d1b.jpg', '', 0, 'index', 'yes', 'yes', '2014-10-31 00:00:00', '2014-11-02 00:00:00', NULL, '2014-10-31 11:20:04', '2014-10-31 11:20:04'),
  (2, 'TTPod', 'new', '/ads/2/9/29d8bf8257d706ed9b613419a72e2d1b.jpg', '', 0, 'index', 'yes', 'yes', '2014-10-31 00:00:00', '2014-11-02 00:00:00', NULL, '2014-10-31 11:20:04', '2014-10-31 11:20:04');

INSERT INTO `ads` (`app_id`, `title`, `location`, `image`, `word`, `sort`, `type`, `is_stock`, `is_top`, `stocked_at`, `unstocked_at`, `deleted_at`, `created_at`, `updated_at`)
VALUES
  (3, '一个', 'search', '/ads/4/6/46e34b0ade19ce1534e51ceeff6edcc3.jpg', '', 0, 'editor', 'yes', 'yes', '2014-10-31 00:00:00', '2014-11-07 00:00:00', '2014-10-27 19:25:40', '2014-10-24 14:34:32', '2014-10-27 19:25:40'),
  (3, '一个', 'new', '/ads/9/c/9c1a8241755afcf28979bc3b31814e2b.jpg', '1111111111', 0, 'editor', 'yes', 'yes', '2014-10-28 00:00:00', '2014-10-30 00:00:00', NULL, '2014-10-27 19:26:03', '2014-10-27 19:26:03'),
  (3, '一个', 'new', '/ads/9/c/9c1a8241755afcf28979bc3b31814e2b.jpg', '1111111111', 0, 'editor', 'yes', 'yes', '2014-10-28 00:00:00', '2014-10-30 00:00:00', NULL, '2014-10-27 19:26:03', '2014-10-27 19:26:03'),
  (3, '一个', 'new', '/ads/9/c/9c1a8241755afcf28979bc3b31814e2b.jpg', '1111111111', 0, 'editor', 'yes', 'yes', '2014-10-28 00:00:00', '2014-10-30 00:00:00', NULL, '2014-10-27 19:26:03', '2014-10-27 19:26:03'),
  (3, '一个', 'new', '/ads/9/c/9c1a8241755afcf28979bc3b31814e2b.jpg', '1111111111', 0, 'editor', 'yes', 'yes', '2014-10-28 00:00:00', '2014-10-30 00:00:00', NULL, '2014-10-27 19:26:03', '2014-10-27 19:26:03'),
  (3, '一个', 'new', '/ads/9/c/9c1a8241755afcf28979bc3b31814e2b.jpg', '1111111111', 0, 'editor', 'yes', 'yes', '2014-10-28 00:00:00', '2014-10-30 00:00:00', NULL, '2014-10-27 19:26:03', '2014-10-27 19:26:03'),
  (3, '一个', 'new', '/ads/9/c/9c1a8241755afcf28979bc3b31814e2b.jpg', '1111111111', 0, 'editor', 'yes', 'yes', '2014-10-28 00:00:00', '2014-10-30 00:00:00', NULL, '2014-10-27 19:26:03', '2014-10-27 19:26:03'),
  (3, '一个', 'new', '/ads/9/c/9c1a8241755afcf28979bc3b31814e2b.jpg', '1111111111', 0, 'editor', 'yes', 'yes', '2014-10-28 00:00:00', '2014-10-30 00:00:00', NULL, '2014-10-27 19:26:03', '2014-10-27 19:26:03'),
  (3, '一个', 'new', '/ads/9/c/9c1a8241755afcf28979bc3b31814e2b.jpg', '1111111111', 0, 'editor', 'yes', 'yes', '2014-10-28 00:00:00', '2014-10-30 00:00:00', NULL, '2014-10-27 19:26:03', '2014-10-27 19:26:03'),
  (3, '一个', 'new', '/ads/9/c/9c1a8241755afcf28979bc3b31814e2b.jpg', '1111111111', 0, 'editor', 'yes', 'yes', '2014-10-28 00:00:00', '2014-10-30 00:00:00', NULL, '2014-10-27 19:26:03', '2014-10-27 19:26:03'),
  (3, '一个', 'new', '/ads/9/c/9c1a8241755afcf28979bc3b31814e2b.jpg', '1111111111', 0, 'editor', 'yes', 'no', '2014-10-28 00:00:00', '2014-10-30 00:00:00', NULL, '2014-10-27 19:26:03', '2014-10-27 19:26:03'),
  (3, '一个', 'new', '/ads/9/c/9c1a8241755afcf28979bc3b31814e2b.jpg', '1111111111', 0, 'editor', 'yes', 'no', '2014-10-28 00:00:00', '2014-10-30 00:00:00', NULL, '2014-10-27 19:26:03', '2014-10-27 19:26:03'),
  (3, '一个', 'new', 'http://lt.qiniu.com/ads/9/c/9c1a8241755afcf28979bc3b31814e2b.jpg', '1111111111', 0, 'editor', 'yes', 'no', '2014-10-28 00:00:00', '2014-10-30 00:00:00', NULL, '2014-10-27 19:26:03', '2014-10-27 19:26:03');


INSERT INTO `ads` (`app_id`, `title`, `location`, `image`, `word`, `sort`, `type`, `is_stock`, `is_top`, `stocked_at`, `unstocked_at`, `deleted_at`, `created_at`, `updated_at`)
VALUES
  (3, '一个', 'new', '', '', 344, 'rank', 'no', 'no', '2014-10-28 00:00:00', '2014-10-31 00:00:00', NULL, '2014-10-27 19:20:20', '2014-10-27 19:21:31'),
  (3, '一个', 'new', '', '', 1, 'rank', 'yes', 'no', '2014-10-28 00:00:00', '2014-10-31 00:00:00', NULL, '2014-10-27 19:21:48', '2014-10-27 19:22:00'),
  (3, '一个', 'hot', '', '', 1, 'rank', 'yes', 'no', '2014-10-28 00:00:00', '2014-10-31 00:00:00', NULL, '2014-10-27 19:21:48', '2014-10-27 19:22:00'),
  (3, '一个', 'hot', '', '', 1, 'rank', 'yes', 'no', '2014-10-28 00:00:00', '2014-10-31 00:00:00', NULL, '2014-10-27 19:21:48', '2014-10-27 19:22:00'),
  (3, '一个', 'up', '', '', 1, 'rank', 'yes', 'no', '2014-10-28 00:00:00', '2014-10-31 00:00:00', NULL, '2014-10-27 19:21:48', '2014-10-27 19:22:00');

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

/*----------------------------------------------------------
| 测试 users 数据库
----------------------------------------------------------*/

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `realname` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `permissions` text COLLATE utf8_unicode_ci,
  `activated` tinyint(1) NOT NULL DEFAULT '0',
  `activation_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `activated_at` timestamp NULL DEFAULT NULL,
  `last_login` timestamp NULL DEFAULT NULL,
  `persist_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `reset_password_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `first_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_activation_code_index` (`activation_code`),
  KEY `users_reset_password_code_index` (`reset_password_code`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
INSERT INTO `users` (`id`, `email`, `username`, `realname`, `password`, `permissions`, `activated`, `activation_code`, `activated_at`, `last_login`, `persist_code`, `reset_password_code`, `first_name`, `last_name`, `created_at`, `updated_at`)
VALUES
  (1, 'test@ltbl.cn', 'test', 'test', '$2y$10$TGjZU3LD7xo8TIhAdsAg7.Sv/FWKLjduncyUQSEKELCqAzDk.YmlK', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2014-10-14 10:33:32', '2014-10-14 10:33:32');



/*----------------------------------------------------------
| 测试 groups 数据库
----------------------------------------------------------*/

CREATE TABLE `groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `permissions` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `department` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `groups_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
INSERT INTO `groups` (`id`, `name`, `permissions`, `created_at`, `updated_at`, `department`) VALUES
  (1, 'test', '{\"apps.stock\":1,\"apps.dounstock\":1,\"apps.edit\":1,\"apps.history\":1,\"apps.draft\":1,\"apps.delete\":1,\"apps.appupload\":1,\"apps.imageupload\":1,\"apps.pending\":1,\"apps.dopass\":1,\"apps.donotpass\":1,\"apps.doallpass\":1,\"apps.doallnotpass\":1,\"apps.notpass\":1,\"apps.unstock\":1,\"appsads.index\":1,\"appsads.create\":1,\"appsads.unstock\":1,\"appsads.edit\":1,\"appsads.delete\":1,\"rankads.index\":1,\"rankads.create\":1,\"rankads.unstock\":1,\"rankads.edit\":1,\"rankads.delete\":1,\"indexads.index\":1,\"indexads.create\":1,\"indexads.unstock\":1,\"indexads.edit\":1,\"indexads.delete\":1,\"editorads.index\":1,\"editorads.create\":1,\"editorads.unstock\":1,\"editorads.edit\":1,\"editorads.delete\":1,\"cateads.index\":1,\"cateads.upload\":1,\"cateads.edit\":1,\"cate.index\":1,\"cate.create\":1,\"cate.edit\":1,\"cate.delete\":1,\"cate.show\":1,\"tag.index\":1,\"tag.create\":1,\"tag.edit\":1,\"tag.delete\":1,\"tag.show\":1,\"rating.index\":1,\"rating.edit\":1,\"comment.index\":1,\"comment.edit\":1,\"comment.delete\":1,\"stopword.index\":1,\"stopword.create\":1,\"stopword.edit\":1,\"stopword.delete\":1,\"keyword.index\":1,\"keyword.store\":1,\"keyword.update\":1,\"keyword.delete\":1,\"users.index\":1,\"users.create\":1,\"users.edit\":1,\"users.delete\":1,\"roles.index\":1,\"roles.create\":1,\"roles.edit\":1,\"roles.delete\":1}', '2014-10-14 10:33:12', '2014-10-14 10:33:12', 1);


/*----------------------------------------------------------
| 测试 users_groups 数据库
----------------------------------------------------------*/

CREATE TABLE `users_groups` (
  `user_id` int(10) unsigned NOT NULL,
  `group_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `users_groups` (`user_id`, `group_id`) VALUES (1, 1);


/*----------------------------------------------------------
| 测试 throttle 数据库
----------------------------------------------------------*/

CREATE TABLE `throttle` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned DEFAULT NULL,
  `ip_address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `attempts` int(11) NOT NULL DEFAULT '0',
  `suspended` tinyint(1) NOT NULL DEFAULT '0',
  `banned` tinyint(1) NOT NULL DEFAULT '0',
  `last_attempt_at` timestamp NULL DEFAULT NULL,
  `suspended_at` timestamp NULL DEFAULT NULL,
  `banned_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `throttle_user_id_index` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*----------------------------------------------------------
| 测试 app_records 数据库
----------------------------------------------------------*/
CREATE TABLE `app_records` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `app_id` int(11) NOT NULL COMMENT '游戏ID',
  `request` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '请求数',
  `download` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '下载数',
  `install` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '安装数',
  `active` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '激活数',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*----------------------------------------------------------
| 测试 app_records 数据库
----------------------------------------------------------*/
CREATE TABLE `record_logs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `app_id` int(11) NOT NULL COMMENT '游戏ID',
  `uuid` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '客户端CLIENTID',
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '用户移动端型号',
  `imei` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'IMEI',
  `os_version` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '系统版本',
  `ip` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '移动端IP',
  `status` enum('request','download','install','active') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'request' COMMENT '日志类型',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `feedbacks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `version` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '客户端版本',
  `content` varchar(500) COLLATE utf8_unicode_ci NOT NULL COMMENT '反馈内容',
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '用户移动端型号',
  `imei` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'IMEI',
  `os_version` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '系统版本',
  `os` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '用户系统',
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '用户邮箱',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `client` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `download_link` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '下载地址',
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '名称',
  `md5` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'APK文件MD5',
  `size_int` int(10) unsigned NOT NULL COMMENT '游戏大小',
  `changes` text COLLATE utf8_unicode_ci NOT NULL COMMENT '更新特性',
  `version` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '版本',
  `version_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '系统代号',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `client` (`id`, `download_link`, `title`, `md5`, `size_int`, `changes`, `version`, `version_code`, `deleted_at`, `created_at`, `updated_at`)
VALUES
  (1, 'http://thisisatest.apk', '游戏市场我来也', '1111111111111', 120004, '编辑点评：《梦回沙城》火热来袭\n经典战、法、道三职业，其核心玩法是很多玩家非常熟悉的自由PK，练级打宝，行会战与万人沙城战，在这里，玩家将再次开启久违的热血之路，重温兄弟情谊，怀旧激情年代，剑指沙城，为荣誉为兄弟战到底！', '0.0.1', '1001', NULL, '2014-10-27 00:00:00', '2014-10-27 00:00:00'),
  (3, 'http://thisisatest.apk', '游戏市场我来也', '1111111111111', 120004, '编辑点评：《梦回沙城》火热来袭\n经典战、法、道三职业，其核心玩法是很多玩家非常熟悉的自由PK，练级打宝，行会战与万人沙城战，在这里，玩家将再次开启久违的热血之路，重温兄弟情谊，怀旧激情年代，剑指沙城，为荣誉为兄弟战到底！', '0.0.2', '1002', NULL, '2014-10-27 00:00:00', '2014-10-27 00:00:00'),
  (5, 'http://thisisatest.apk', '游戏市场我来也', '1111111111111', 120004, '编辑点评：《梦回沙城》火热来袭\n经典战、法、道三职业，其核心玩法是很多玩家非常熟悉的自由PK，练级打宝，行会战与万人沙城战，在这里，玩家将再次开启久违的热血之路，重温兄弟情谊，怀旧激情年代，剑指沙城，为荣誉为兄弟战到底！', '1.0.1', '2001', NULL, '2014-10-27 00:00:00', '2014-10-27 00:00:00');

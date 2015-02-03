<?php

namespace App\Classes\Crawler;

interface DomParserInterface
{

    /**
     * 执行解析器
     *
     *
     * @return void
     * @author 
     **/
    function doParse();

    /**
     * 获取游戏名称
     *
     *
     * @return string
     * @author 
     **/
    function getTitle();

    /**
     * 获取 version code
     *
     *
     * @return int
     * @author 
     **/
    function getVersionCode();

    /**
     * 获取下载地址
     *
     *
     * @return string
     * @author 
     **/
    function getDownloadLink();

}
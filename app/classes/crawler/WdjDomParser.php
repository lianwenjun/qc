<?php

namespace App\Classes\Crawler;

use Goutte\Client;

class WdjDomParser extends BaseDomParser implements DomParserInterface
{
    protected $baseURL = 'http://www.wandoujia.com/apps/';

    /**
     * 获取游戏名称
     *
     *
     * @return string
     * @author 
     **/
    public function getTitle()
    {
        return $this->crawler->filter('span.title')->first()->html();
    }

    /**
     * 获取 version code
     *
     *
     * @return int
     * @author 
     **/
    public function getVersionCode()
    {
        return intval($this->crawler->filter('a.push-btn')->first()->attr('data-vc'));
    }

    /**
     * 获取下载地址
     *
     *
     * @return string
     * @author 
     **/
    public function getDownloadLink()
    {
        return $this->crawler->filter('a.install-btn')->first()->attr('href');
    }
}
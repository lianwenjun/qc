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
        try {
            return $this->crawler->filter('span.title')->first()->html();
        } catch (\InvalidArgumentException $e) {
            throw new DomParserException('找不到游戏名称');
        }
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
        try {
            return intval($this->crawler->filter('a.push-btn')->first()->attr('data-vc'));
        } catch (\InvalidArgumentException $e) {
            throw new DomParserException('找不到游戏名称');
        }
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
        try {
            return $this->crawler->filter('a.install-btn')->first()->attr('href');
        } catch (\InvalidArgumentException $e) {
            throw new DomParserException('找不到游戏名称');
        }
    }
}
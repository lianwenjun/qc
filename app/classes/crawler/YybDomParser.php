<?php

namespace App\Classes\Crawler;

use Goutte\Client;

class YybDomParser extends BaseDomParser implements DomParserInterface
{
    protected $baseURL = 'http://sj.qq.com/myapp/detail.htm?apkName=';

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
            return $this->crawler->filter('div.det-name-int')->first()->html();
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
            $content = $this->crawler->filter('script')->last()->html();

            // 获得apkCode的内容
            preg_match('/apkCode\s*:\s*\"([0-9]+)\"/', $content, $matches);
            // error_log(print_r($matches, true));

            if (array_key_exists(1, $matches)) {
                return $matches[1];
            } else {
                throw new DomParserException('找不到version code');
            }
        } catch (\InvalidArgumentException $e) {
            throw new DomParserException('找不到version code');
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
            $content = $this->crawler->filter('script')->last()->html();

            // 获得downUrl的内容
            preg_match('/downUrl\s*:\s*\"([^\"]+)\"/', $content, $matches);
            // error_log(print_r($matches, true));

            if (array_key_exists(1, $matches)) {
                return $matches[1];
            } else {
                throw new DomParserException('找不到下载地址');
            }
        } catch (\InvalidArgumentException $e) {
            throw new DomParserException('找不到下载地址');
        }
    }
}
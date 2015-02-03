<?php

namespace App\Classes\Crawler;

use Goutte\Client;

abstract class BaseDomParser implements DomParserInterface
{
    // Base URL (子类需要覆盖此属性！！！！)
    protected $baseURL;

    // 包名
    protected $name;

    // Client
    protected $client;

    // Crawler
    protected $crawler;

    /**
     * 构造方法
     *
     * @return void
     * @author 
     **/
    public function __construct($name)
    {
        $this->name = $name;
        $this->client = new Client();
    }

    /**
     * 开始解析
     *
     * @return void
     * @author 
     **/
    public function doParse()
    {
        if ($this->baseURL && $this->name) {
            $this->crawler = $this->client->request('GET', $this->baseURL.$this->name);
        }
    }


}
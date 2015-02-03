<?php

namespace App\Classes\Crawler;

class DomParserFactory
{
    /**
     * 根据site创建一个对应的parser并返回
     *
     * @return DomParserInterface
     * @author 
     **/
    public static function createDomParser($site, $name)
    {
        switch ($site) {
            case 'wdj' :
                // 豌豆荚
                return new WdjDomParser($name);
            case 'yyb' :
                // 应用宝
                return new YybDomParser($name);
            default :
                return null;
        }
    }
}
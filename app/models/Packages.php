<?php

use App\Classes\Crawler\DomParserFactory;
use App\Classes\Crawler\DomParserException;

class Packages extends Base
{
    public $table = 'packages';
    public $fillable = ['site', 'name', 'title', 'version_code', 'download_link'];

    /**
     * 定义关联关系
     *
     * @return Apps
     * @author 
     **/
    public function app()
    {
        $this->belongsTo('Apps', 'name', 'pack');
    }

    /**
     * 读取apps中的所有条目，爬取source为lt的所有内容
     *
     * @return void
     * @author 
     **/
    public static function refreshListFromApps()
    {
        $apps = Apps::select(['source', 'pack'])->get();

        // 目前只在应用宝下爬
        foreach ($apps as $app) {
            if ($app->source == 'lt') {
                static::refresh($app->pack, 'yyb');
            }
        }

        return true;
    }

    /**
     * 爬取单个包在单个网站中的内容
     *
     * @param $name string 包名
     * @param $site string 来源网站
     *
     * @return void
     * @author 
     **/
    public static function refresh($name, $site)
    {
        $parser = DomParserFactory::createDomParser($site, $name);

        if ($parser) {
            $parser->doParse();

            try {
                $data = [
                    'site' => $site,
                    'name' => $name,
                    'title' => $parser->getTitle(),
                    'version_code' => $parser->getVersionCode(),
                    'download_link' => $parser->getDownloadLink(),
                ];
                
                if ($model = static::createOrUpdate($data)) {
                    return true;
                }
            } catch (DomParserException $e) {

            }
        }

        return false;
    }

    /**
     * 创建或更新数据表中的内容
     *
     * @param array 爬到的数据
     *
     * @return void
     * @author 
     **/
    private static function createOrUpdate($data)
    {
        //先查找是否已经有记录了
        $model = static::where('site', $data['site'])
                        ->where('name', $data['name'])
                        ->first();

        if ($model) {
            $model->update($data);
        } else {
            $model = static::create($data);
        }

        return $model;
    }

    /**
     * 下载apk（暂时不使用）
     *
     * @return void
     * @author 
     **/
    private function download()
    {
        @mkdir(public_path().'/upload');

        $curl = curl_init($this->download_link);
        curl_setopt($curl, CURLOPT_HTTPHEADER, ['Accept: '.'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8','Connection: keep-alive']);
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.66 Safari/537.36');
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 0);
        curl_setopt($curl, CURLOPT_TIMEOUT, 300);
        curl_setopt($curl, CURLOPT_AUTOREFERER, 1);
        curl_setopt($curl, CURLOPT_WRITEFUNCTION, array($this,'filePutContent'));
        $data = curl_exec($curl);
        curl_close($curl);
    }

    /**
     * 分段下载并保存apk（暂时不使用）
     *
     * @param $curl
     * @param $string
     *
     * @return int
     */
    private function filePutContent($curl, $string)
    {
        $writeFile = public_path().'/upload/test.apk';

        //写入本地文件
        if(!empty($writeFile)){
            $fp = fopen($writeFile, 'a');
            fwrite($fp,$string);
            fclose($fp);
        }

        return strlen($string);
    }
}
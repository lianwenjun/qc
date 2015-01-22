<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ExportAnything extends Command
{
    /**
     * 命令名称
     *
     * @var string
     */
    protected $name = 'export-any';

    /**
     * 命令注释
     *
     * @var string
     */
    protected $description = '处理各种运营导出需求';

    /**
     * 获取执行命令的参数
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['funcName', InputArgument::REQUIRED, '执行导出数据的方法名'],
        ];
    }

    protected function getOptions()
    {
        return [];
    }

    public function fire()
    {
        $func = $this->argument('funcName');
        $this->$func();
    }

    public function stockWithOutCat()
    {
        Excel::create('stock-without-cat', function($excel)
        {
            $excel->sheet('sheet1', function($sheet)
            {
                Apps::select('id', 'title', 'pack')
                      ->where('status', 'stock')
                      ->chunk(1000, function($data) use($sheet)
                        {
                            foreach ($data as $key => $value) {
                                $cats = AppCats::select('cat_id')
                                                 ->where('app_id', $value->id)
                                                 ->where('cat_id', '<', 2000)
                                                 ->get()->toArray();
                                $tags = AppCats::select('cat_id')
                                                 ->where('app_id', $value->id)
                                                 ->where('cat_id', '>', 2000)
                                                 ->get()->toArray();

                                if (empty($cats) || empty($tags)) {
                                    $this->info("add id:{$value->id}, title:{$value->title}, pack:{$value->pack}");
                                    $sheet->appendRow(json_decode(json_encode($value), true));
                                }
                            }
                        });
            });
        })->store('csv', '/var/data');
    }
}
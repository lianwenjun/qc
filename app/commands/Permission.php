<?php

use Illuminate\Console\Command;

class permission extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'permission';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'auto make permission config';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {

        $routes = Route::getRoutes();

        $permissions = []; // 需要管理的权限
        foreach ($routes as $route) {
            if($name = $route->getName()) {
                $permissions[] = $name;
            }
        }

        ob_start();
        echo "<?php \n// 此文件由命令生成\nreturn ";
        var_export($permissions);
        echo ";";
        $content = ob_get_contents();

        file_put_contents(app_path() . '/config' . '/permission.php', $content);
    }

}

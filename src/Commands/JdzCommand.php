<?php

namespace Liuweiliang\Liuweiliang;

use Illuminate\Console\Command;

class JdzCommand extends Command
{
    protected $signature = 'make:Jdz {param}';
    protected $description = '机动组 自定义创建文件命令';
    protected static $controllerDir = 'Controllers/';
    protected static $modelDir = 'Models/';
    protected static $serviceDir = 'Services/';
    public $actionArr = [
        0 => 'makeController',//创建控制器
        1 => 'makeModel',//创建模型
        2 => 'makeService',//创建服务层
    ];

    public function __construct()
    {
        parent::__construct();

    }

    /**
     * FunctionName：makeController
     * Description：
     * Author：lwl
     */
    public function makeController()
    {
        $param = $this->argument('param');

        $controller = projectPath()['project_path'] . self::$controllerDir . $param . '.php';
        $namespace = trim(projectPath()['project'],'\\');

        if (file_exists($controller)) {
            $this->error("已经存在 {$param} 控制器");
            die();
        }
        $bool = $this->mkDoc($controller, $param,$namespace,1);
        if ($bool) {
            $this->info($controller . '文件创建成功');
            die();
        }
        $this->error($controller . '文件创建失败');
        die();
    }


    public function makeModel()
    {
        $param = $this->argument('param');
        $model = projectPath()['project_path'] . self::$modelDir . $param . '.php';
        $namespace = trim(projectPath()['project'],'\\');
        if (file_exists($model)) {
            $this->error("已经存在 {$param} 模型");
            die();
        }
        $bool = $this->mkDoc($model, $param,$namespace,2);
        if ($bool) {
            $this->info($model . '文件创建成功');
            die();
        }
        $this->error($model . '文件创建失败');
        die();
    }

    public function makeService()
    {
        $param = $this->argument('param');
        $model = projectPath()['project_path'] . self::$serviceDir . $param . '.php';
        $namespace = trim(projectPath()['project'],'\\');
        if (file_exists($model)) {
            $this->error("已经存在 {$param} 服务层");
            die();
        }
        $bool = $this->mkDoc($model, $param,$namespace,3);
        if ($bool) {
            $this->info($model . '文件创建成功');
            die();
        }
        $this->error($model . '文件创建失败');
        die();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $param = $this->argument('param');
        $this->line($param);
        $this->initConsole();
        return true;
    }

    /**
     * FunctionName：initConsole
     * Description：
     * Author：lwl
     */
    public function initConsole()
    {

        $answer = $this->choice('请选择要操作的数字', $this->actionArr);
        if (array_key_exists(intval($answer), $this->actionArr) || in_array($answer, $this->actionArr)) {
            $this->info('正在执行：' . $answer . PHP_EOL);
            $this->$answer();
        }
        // 持续交互
//        $this->initConsole();
    }

    /**
     * FunctionName：mkDoc
     * Description：创建文件
     * Author：lwl
     * @param $filename
     * @param string $param
     * @return bool
     */
    protected function mkDoc($filename, $param,$namespace, $type = 1)
    {
        $res = fopen($filename, 'w');
        switch ($type) {
            case 1:
                $content = self::controllerContent($param,$namespace);
                break;
            case 2:
                $content = self::modelContent($param,$namespace);
                break;
            default:
                $content = self::serviceContent($param,$namespace);
                break;
        }
        //$content = self::controllerContent($param);
        fputs($res, $content);
        fclose($res);
        return true;
    }

    protected static function controllerContent($param,$namespace)
    {
        $date = date('Y/m/d H:i:s');;
        return <<<EOF
<?php
/**
 * Copyright (C), 2021-2021, Shall Buy Life info. Co., Ltd.
 * FileName:$param.php
 * Description:
 *
 * @author:
 * @Create Date    $date
 * @Update Date    $date
 * @version v1.0
 */

namespace $namespace\Controllers;

use App\Http\Controllers\Controller;

class $param extends Controller
{

    public function __construct()
    {


    }

}
EOF;
    }


    public static function modelContent($param,$namespace)
    {
        $date = date('Y/m/d H:i:s');
        $table = '$table';
        $fillable = '$fillable';
        return <<<EOF
<?php
/**
 * Copyright (C), 2016-2018, Shall Buy Life info. Co., Ltd.
 * FileName:
 * Description: 说明
 *
 * @author
 * @Create Date    2021/6/9 14:52
 * @Update Date    2021/6/9 14:52 By drx
 * @version v1.0
 */

namespace $namespace\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class $param extends Model
{
    use SoftDeletes;
    protected $table = 'life_';

    protected $fillable = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
EOF;
    }


    public static function serviceContent($param,$namespace)
    {
        $date = date('Y/m/d H:i:s');
        $table = '$table';
        $fillable = '$fillable';
        return <<<EOF
<?php
/**
 * Copyright (C), 2016-2018, Shall Buy Life info. Co., Ltd.
 * FileName:
 * Description: 说明
 *
 * @author
 * @Create Date
 * @Update Date
 * @version v1.0
 */

namespace $namespace\Services;

class $param
{

}
EOF;
    }

}

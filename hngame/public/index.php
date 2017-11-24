<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
session_start();
// [ 应用入口文件 ]
// 定义应用目录
#define('__DIR__', dirname(__FILE__));
define('APP_PATH', __DIR__ . '/../application/');
define('WEB_PATH', __DIR__);
define('APP_DEBUG', true);

// 加载框架引导文件
require __DIR__ . '/../thinkphp/start.php';
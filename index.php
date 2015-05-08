<?php
// 定义根目录
define('RUNTIME_PATH', dirname(__FILE__));
require_once(RUNTIME_PATH . '/core/core.php');

// 加载路由
new Router();
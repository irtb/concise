<?php
/*
 * 全局变量
 */

// 核心程序目录
define('CORE_PATH', RUNTIME_PATH.'/core/'); 

// 配置文件目录
define('CONF_PATH', RUNTIME_PATH.'/core/conf/');

// Smarty 目录
define('SMARTY_LIB_PATH', CORE_PATH.'/ext/Smarty/libs/');

// 文件上传目录
define('UPLOAD_PATH', RUNTIME_PATH.'/uploads/'); 

// 项目目录
define('APP_PATH', RUNTIME_PATH.'/application/'); 

// 缓存目录
define('CACHE_PATH', RUNTIME_PATH.'/runtime/'); 

// 项目域名
define("WWW", "http://19880327.sinaapp.com/");

// 公用文件目录
define('PUBLIC_PATH', WWW.'/public/');

// 日志存放目录
define('PATH_LOG', RUNTIME_PATH.'/logs/'); 
// 日志文件类型
define('EXT_LOG', '.log');
// 日志文件最大限制(b)
define('LOG_FILE_SIZE', 20480000); 




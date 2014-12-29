<?php 
error_reporting(E_ALL & ~E_NOTICE & ~E_NOTICE);
//项目目录
define("APP_PATH", RUNTIME_PATH."/Concise"); 
//核心程序目录
define("CORE_PATH", RUNTIME_PATH."/Core");
//日志存放目录
define("PATH_LOG", RUNTIME_PATH."/Log");
//日志文件类型
define("EXT_LOG",".log");
//日志文件最大限制
define("LOG_FILE_SIZE",20480000); 
//Smarty 目录
define("SMARTY_LIB_PATH", CORE_PATH."/Extension/Smarty/libs");
//文件上传目录
define("UPLOAD_PATH", APP_PATH."/Uploads"); 
//域名
define("WWW","http://concise.com");
//公用文件目录
define("PUBLIC_PATH", APP_PATH."/Public");
/*
 * Smarty 相关设置
 */
require_once(SMARTY_LIB_PATH."/Smarty.class.php");
$smarty = new Smarty();
//是否使用缓存
$smarty->caching = false;
//设置模板目录
$smarty->template_dir = APP_PATH."/Templet"; 
//设置编译目录
$smarty->compile_dir = RUNTIME_PATH."/Runtime/Templet_c"; 
//缓存文件夹
$smarty->cache_dir = RUNTIME_PATH."/Runtime/Cache/"; 
//自定义左定界符
$smarty->left_delimiter = "<{"; 
//自定义左定界符
$smarty->right_delimiter = "}>"; 


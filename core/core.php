<?php 
// 引入常量|基础函数|全局配置
error_reporting(E_ALL & ~E_NOTICE & ~E_NOTICE);
date_default_timezone_set('Asia/Shanghai');
include_once RUNTIME_PATH."/core/conf/define.php";
include_once RUNTIME_PATH."/core/conf/conf.php";
include_once RUNTIME_PATH."/core/conf/db.php";
function classAutoLoader($class){
    $classFile = CORE_PATH."lib/".$class.".class.php";
    if(is_file($classFile)&&!class_exists($class)) include $classFile;
}
spl_autoload_register('classAutoLoader');
include_once RUNTIME_PATH."/core/common/func.php";

<?php 
// 引入常量|基础函数|全局配置
date_default_timezone_set('Asia/Shanghai');
require_once(RUNTIME_PATH."/Core/Conf/config.php");
// 自动加载核心类库
function classAutoLoader($class){
    $classFile = CORE_PATH."/Lib/".$class.".class.php";
    if(is_file($classFile) && !class_exists($class)) {
    	require_once($classFile);
    }
}
spl_autoload_register('classAutoLoader');
// new Router();
require_once(CORE_PATH."/Conf/define.php");
require_once(CORE_PATH."/Common/func.php");
 
 ?>
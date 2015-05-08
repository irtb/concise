<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
// +----------------------------------------------------------------------+
// | PHP version 5.6.1                                                    |
// +----------------------------------------------------------------------+
// | Authors: 简单的路由                                                  |
// |          liuzm <liuzm@eswine.com>                                    |
// +----------------------------------------------------------------------+
//

class Router {

    public $smarty;

    public function __construct() {

        define('MODULE_DIR', APP_PATH . 'action/');
        $apppath= str_replace($_SERVER['DOCUMENT_ROOT'], '', __FILE__);

        //计算出index.php后面的字段 index.php/controller/methon/id/3 
        $SE_STRING=str_replace($apppath, '', $_SERVER['REQUEST_URI']);    
        $SE_STRING=trim($SE_STRING,'/');
        $ary_url=array();
        $ary_se=explode('/', $SE_STRING);
        $se_count=count($ary_se);
        //路由控制
        if($se_count == 1 && $ary_se[0] != '') {
            $ary_url['controller'] = $ary_se[0];
        } else if ($se_count == 1 && $ary_se[0] == '') {
            // 默认方法
            $ary_url['controller'] = 'index';
            $ary_url['method'] = 'idx';
        } else if($se_count > 1 && $ary_se[0] != 'public') {
            //计算后面的参数，key-value
            $ary_url['controller'] = $ary_se[0];
            $ary_url['method'] = $ary_se[1];
            if($se_count > 2 && $se_count%2 !=0 ) { 
                //没有形成key-value形式
                die('参数错误');
            }else{
                for($i=2; $i<$se_count; $i=$i+2) {
                    $ary_kv_hash = array(strtolower($ary_se[$i]) => $ary_se[$i+1]);
                    $ary_url[pramers] = array_merge($ary_url[pramers], $ary_kv_hash);
                }
            }
        } else {
            return;
        }

        $module_name = $ary_url['controller'];
        $module_file = MODULE_DIR . $module_name.'.class.php';
        $method_name = $ary_url['method'];
        if(file_exists($module_file)) {
            // 实例化Action
            include($module_file);
            $obj_module = new $module_name();
            if(!method_exists($obj_module, $method_name)) {
                die('方法不存在');
            } else {
                //该方法是否能被调用
                if(is_callable(array($obj_module, $method_name))) { 
                    //执行a方法,并把key-value参数的数组传过去
                    $get_return = $obj_module->$method_name($ary_url[pramers]);
                    //返回值不为空
                    if(!is_null($get_return)){
                        var_dump($get_return);
                    }
                }else{
                    die('该方法不能被调用');
                }
            }
        } else {
            die('模块文件不存在');
        }
    }
    
}

?>
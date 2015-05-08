<?php
class base {
	
	function __construct() {
		require_once SMARTY_LIB_PATH."Smarty.class.php";
        $smarty = new Smarty();
        // 开发模式
		$smarty->debugging = false;
		// 是否使用缓存
		$smarty->caching = true; 
		// 设置模板目录
		$smarty->template_dir = APP_PATH."template/"; 
		// 设置编译目录
		$smarty->compile_dir = CACHE_PATH."template/"; 
		// 缓存文件夹
		$smarty->cache_dir = CACHE_PATH."cache/"; 
		// 自定义左定界符
		$smarty->left_delimiter = "<{"; 
		// 自定义左定界符
		$smarty->right_delimiter = "}>";
	}
	
}

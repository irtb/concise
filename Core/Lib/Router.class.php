<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
// +----------------------------------------------------------------------+
// | PHP version 5                                                        |
// +----------------------------------------------------------------------+
// | Copyright (c) 1997-2004 The PHP Group                                |
// +----------------------------------------------------------------------+
// | This source file is subject to version 3.0 of the PHP license,       |
// | that is bundled with this package in the file LICENSE, and is        |
// | available through the world-wide-web at the following url:           |
// | http://www.php.net/license/3_0.txt.                                  |
// | If you did not receive a copy of the PHP license and are unable to   |
// | obtain it through the world-wide-web, please send a note to          |
// | license@php.net so we can mail you a copy immediately.               |
// +----------------------------------------------------------------------+
// | Authors: 简单的路由                                                  |
// |          liuzm <liuzm@eswine.com>                                    |
// +----------------------------------------------------------------------+
//

class Router {

    private $url;
    private $server;

    public function __construct() {

        $url = APP_PATH."/Home/Controller".$_SERVER['REQUEST_URI'];
        if (!file_exists($url)) {
        	header("http://".WWW."/lost");
        }

    }

    public function routerCheck() {

        define('IS_CGI', (0 === strpos(PHP_SAPI,'cgi') || false !== strpos(PHP_SAPI,'fcgi')) ? 1 : 0 );
        define('IS_WIN', strstr(PHP_OS, 'WIN') ? 1 : 0 );
        define('IS_CLI', PHP_SAPI == 'cli' ? 1 : 0 );

        if(!IS_CLI) {
            // 当前文件名
            if(!defined('_PHP_FILE_')) {
                if(IS_CGI) {
                    //CGI/FASTCGI模式下
                    $_temp  = explode('.php',$_SERVER['PHP_SELF']);
                    define('_PHP_FILE_', rtrim(str_replace($_SERVER['HTTP_HOST'],'',$_temp[0].'.php'),'/'));
                }else {
                    define('_PHP_FILE_', rtrim($_SERVER['SCRIPT_NAME'],'/'));
                }
            }
            if(!defined('__ROOT__')) {
                $_root = rtrim(dirname(_PHP_FILE_),'/');
                define('__ROOT__', (($_root=='/' || $_root == '\\') ? '' : $_root));
            }
        }
    }
    
}

?>
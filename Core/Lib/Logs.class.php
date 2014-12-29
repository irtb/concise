<?php 
/*
 * 日志操作类
 * Author: liuzm(liuzm@eswine.com)
 *
*/
class Logs{
	public static $log = array();
	public static $format = '[ c ]';

	const FILE   = 3;

	public static function record($message, $record=false) {
    	if($record) {
    		$now = date(self::$format);
    		self::$log[] =   "{$now} ".$_SERVER['REQUEST_URI']." | {$message}\r\n";
    	}
	}

	public static function write( $message, $type=self::FILE, $destination='', $extra='', $et) {
    	$now = date(self::$format);
    	if(self::FILE == $type) { 
    		if(empty($destination)) {
                if ($et == 1) {
                    $destination = PATH_LOG . 'error_'.date('Y_m_d') . EXT_LOG;
                }elseif ($et == 2) {
                    $destination = PATH_LOG . 'connect_'.date('Y_m_d') . EXT_LOG;
                }elseif ($et == 3) {
                    $destination = PATH_LOG . 'action_'.date('Y_m_d') . EXT_LOG;
                }else{
                    $destination = PATH_LOG . 'other_'.date('Y_m_d') . EXT_LOG;
                }
                //检测日志文件大小，超过配置大小则备份日志文件重新生成
    			if(is_file( $destination ) && floor( LOG_FILE_SIZE ) <= filesize($destination) ) {
        			rename($destination,dirname($destination).'/'.basename($destination, EXT_LOG). '-' .time(). EXT_LOG);
                }
    		}
   			error_log("{$now} ".$_SERVER['REMOTE_ADDR']." | ".$_SERVER['REQUEST_URI']." | {$message}\r\n", $type, $destination, $extra);
		}
	}
}

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
                    $destination = LOG_PATH . '/error_'.date('Y_m_d') . LOG_EXT;
                }elseif ($et == 2) {
                    $destination = LOG_PATH . '/connect_'.date('Y_m_d') . LOG_EXT;
                }elseif ($et == 3) {
                    $destination = LOG_PATH . '/action_'.date('Y_m_d') . LOG_EXT;
                }else{
                    $destination = LOG_PATH . '/other_'.date('Y_m_d') . LOG_EXT;
                }
                //检测日志文件大小，超过配置大小则备份日志文件重新生成
    			if(is_file( $destination ) && floor( LOG_FILE_SIZE ) <= filesize($destination) ) {
        			rename($destination,dirname($destination).'/'.basename($destination, LOG_EXT). '-' .time(). LOG_EXT);
                }
    		}
   			error_log("{$now} ".$_SERVER['REMOTE_ADDR']." | ".$_SERVER['REQUEST_URI']." | {$message}\r\n", $type, $destination, $extra);
		}
	}
}

<?php
class index {
	public $smarty;

	function user($smarty) {
		dump($smarty);
		echo "user方法<br />Hello SAE ";
	}

	function idx($smarty) {
		dump($smarty);
		echo '初始化';
	}
}

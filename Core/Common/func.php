<?php
/**
 * 函数库
 */

// 开发打印数据
function dump($data) {
	echo '<pre>';
	var_dump($data);
	echo '</pre>';
}

// 加密Tokey
function getTokey() {
	$db = Db::init();
	$data = array();
	$sql = "SELECT `id`, `tokey`, `status`, `add_time`, `dis_time` FROM `cs_tokey` WHERE `status` = 1";
	$res = $db->getAll($sql, $data);
	return $res;
}
<?php
include("../../../../../Core/core.php");

$db = Db::init();
$user = !empty($_POST['name']) ? trim($_POST['name']) : die('用户名不能为空');
$pass = !empty($_POST['pwd']) ? trim($_POST['pwd']) : die('密码不能为空');

$ck_user_data = array('user' => $user);
$ck_user_sql = "SELECT `id`, `name`, `pwd`, `tokey`, `reg_time`, `last_edit_time`, `eyt_type` FROM `cs_user` WHERE `name` = :user";
$ck_user = $db->getRow($ck_user_sql, $ck_user_data);
if ($ck_user) {
	$all_tokey = getTokey();
	$tokey = $all_tokey[$ck_user['tokey']]['tokey'];
	$user_pass = create_user_password($pass, $ck_user['reg_time'], $tokey, $ck_user['eyt_type']);
	if ($user_pass === $ck_user['pwd']) {
		unset($_COOKIE["csid"]);
		unset($_COOKIE["cstk"]);
		setcookie("csid", $ck_user['id'], time()+3600, "/", "concise.com");
		setcookie("cstk", md5($ck_user['id'].$ck_user['tokey'].$ck_user['eyt_type']), time()+3600, "/", "concise.com");
		echo json_encode(array('cd' => 0, 'msg' => '哇咔咔！登陆成功鸟！'));exit;
	} else {
		echo json_encode(array('cd' => 2, 'msg' => '亲，密码不正确哟！'));exit;
	}
} else {
	echo json_encode(array('cd' => 1, 'msg' => '亲，用户名不存在哟！'));exit;
}
<?php 
include("./Core/core.php");
if (!isset($_COOKIE['csid']) || empty($_COOKIE['csid']) || !isset($_COOKIE['cstk']) || empty($_COOKIE['cstk'])) {
	header("location:".WWW."/login.php");exit;
} else {
	$id = trim(intval($_COOKIE['csid']));
	$tk = trim($_COOKIE['cstk']);
	$user = getUser($id);
	if ($user) {
		$tokey = md5($user['id'].$user['tokey'].$user['eyt_type']);
		if ($tk === $tokey) {
			$smarty->display("admin.html");
		} else {
			header("location:".WWW."/login.php");exit;
		}
	} else {
		header("location:".WWW."/login.php");exit;
	}
}

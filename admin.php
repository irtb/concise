<?php 
include("./Core/core.php");
if (!isset($_COOKIE['uid']) || empty($_COOKIE['uid']) || !isset($_COOKIE['tk']) || empty($_COOKIE['tk'])) {
	header("location:".WWW."/login.php");
} else {
	$id = trim(intval($_COOKIE['uid']));
	$tk = trim($_COOKIE['tk']);
	$key = TOKEY;
}
$smarty->display("admin.html");
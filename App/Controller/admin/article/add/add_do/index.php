<?php 
include("../../../../../../Core/core.php");
$db = Db::init();
$data = array('name' => trim($_POST['name']), 'pid' => $_POST['pid'], 'status' => $_POST['status'], 'add_time' => time(), 'last_edit_time' => time());
$res = $db->addRow('cs_category', $data);
if ($res) {
	json_encode(array('code' => 1, 'msg' => '添加成功'));exit;
} else {
	json_encode(array('code' => 0, 'msg' => '添加失败'));exit;
}


 ?>
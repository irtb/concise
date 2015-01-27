<?php 
include("../../../../../../Core/core.php");
$name = !empty($_POST['name']) ? trim($_POST['name']) : die('分类名称不能为空');
$pid = $_POST['pid'];
$level = $_POST['level'];
$status = !empty($_POST['status']) ? $_POST['status'] : die('分类状态不能为空');
$db = Db::init();
$data = array('name' => $name, 'pid' => $pid, 'level' => $level, 'status' => $status, 'add_time' => time(), 'last_edit_time' => time());
$res = $db->addRow('cs_category', $data);
if ($res) {
	echo json_encode(array('cd' => 1, 'msg' => '添加成功'));exit;
} else {
	echo json_encode(array('cd' => 0, 'msg' => '添加失败'));exit;
}


 ?>
<?php 
include("../../../../../../Core/core.php");
$name = !empty($_POST['name']) ? trim($_POST['name']) : die('分类名称不能为空');
$pid = !empty($_POST['pid']) ? $_POST['pid'] : die('分类所属不能为空');
$status = !empty($_POST['status']) ? $_POST['status'] : die('分类状态不能为空');
$db = Db::init();
$data = array('name' => $name, 'pid' => $pid, 'status' => $status, 'add_time' => time(), 'last_edit_time' => time());
$res = $db->addRow('cs_category', $data);
if ($res) {
	json_encode(array('code' => 1, 'msg' => '添加成功'));exit;
} else {
	json_encode(array('code' => 0, 'msg' => '添加失败'));exit;
}


 ?>
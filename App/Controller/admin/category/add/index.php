<?php 
include("../../../../../Core/core.php");

// dump();exit;
$category = getSubs();
// dump($category);exit;
if (!empty($category)) {
	foreach ($category as $k => $v) {
		$str = ">>";
		for ($i=1; $i < $v['level']; $i++) { 
			$strs .= $str;
		}
		if ($v['level'] != 1) {
			$cat .= "<option level='".$v['level']."' value='".$v['id']."'> &nbsp;&nbsp;-".$strs.$v['name']."</option>";
		} else {
			$cat .= "<option level='1' value='".$v['id']."'>".$v['name']."</option>";
		}
	}
}
// dump($cat);exit;

$smarty->assign("cat", $cat);
$smarty->display("Admin/category/add.html");
?>
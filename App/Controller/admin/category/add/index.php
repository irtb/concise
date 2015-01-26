<?php 
include("../../../../../Core/core.php");

// dump();exit;
$category = getSubs();
if (!empty($category)) {
	foreach ($category as $k => $v) {
		$cat .= "<option value='".$v['id']."'>".$v['name']."</option>";
	}
}

$smarty->assign("cat", $cat);
$smarty->display("Admin/category/add.html");
?>
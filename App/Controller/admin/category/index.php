<?php 
include("../../../../Core/core.php");
dump(getCategory());exit;
$smarty->assign("category", getCategory());
$smarty->display("Admin/category/list.html");

 ?>
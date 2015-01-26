<?php 
include("../../../../Core/core.php");
$smarty->assign("category", getCategory());
$smarty->display("Admin/category/list.html");

 ?>
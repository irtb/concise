<?php 
include("../../../Core/core.php");

checkLogin();
$smarty->display("Admin/index.html");

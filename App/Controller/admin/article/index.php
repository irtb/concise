<?php 
include("../../../../Core/core.php");

$article = getArticle();

$cat = getCategory(0);

$smarty->display("Admin/article/list.html");

?>
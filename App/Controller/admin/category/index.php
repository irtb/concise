<?php 
include("../../../../Core/core.php");
$tpye = array('文章','图片','下载');


$res = addType('文章');
dump($res);
exit;
foreach ($type as $key => $value) {
	 addType($value);
}
echo '*************';
var_dump($smarty);

 ?>
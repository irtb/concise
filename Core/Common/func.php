<?php
/**
 * 函数库
 */

// 开发打印数据
function dump($data) {
	echo '<pre>';
	var_dump($data);
	echo '</pre>';
}

// 加密Tokey
function getTokey() {
	$db = Db::init();
	$data = array();
	$sql = "SELECT `id`, `tokey`, `status`, `add_time`, `dis_time` FROM `cs_tokey` WHERE `status` = 1";
	$res = $db->getAll($sql, $data);
	return $res;
}

// 添加加密Tokey
function addTokey($num) {
	$db = Db::init();
	for ($i=0; $i < $num; $i++) { 
		
		$tokey = create_password(32);
		$data = array('tokey' => $tokey, 'status' => 1, 'add_time' => time(), 'dis_time' => time());
		$res = $db->addRow('cs_tokey', $data);
		if ($res) {
			$r += 1;
		}
	}
	return $r;
}

// 添加类型
function addType() {
	$db = Db::init();
	$data = array('name' => '文章', 'status' => 1, 'add_time' => time());
	$res = $db->addRow('cs_type', $data);
	if ($res) {
		$info += 1;
	}

	return $info;
}

// 查询用户
function getUser($id) {
	$db = Db::init();
	$data = array('id' => $id);
	$sql = "SELECT `id`, `name`, `pwd`, `tokey`, `reg_time`, `last_edit_time`, `eyt_type` FROM `cs_user` WHERE `id` = :id AND `status` = 1";
	$res = $db->getRow($sql, $data);
	return $res;
}

// 添加用户
function addUser($name, $pass, $time, $eyt_type) {

	$tokey_id = mt_rand(1, 1000);
	$tky = getTokey();
	$tokey = $tky[$tokey_id]['tokey'];
	$eyt_type = mt_rand(1, 5);
	$pass = create_user_password($pass, time(), $tokey, $eyt_type);
	$data = array('name' => $name, 'pwd' => $pass, 'tokey' => $tokey_id, 'reg_time' => time(), 'last_edit_time' => time(), 'eyt_type' => $eyt_type);
	$res = $db->addRow('cs_user', $data);
	
	return $res;
}

// 生成Tokey
function create_password($length) {
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*';
	$password = '';
	for ( $i = 0; $i < $length; $i++ ) {
		// $password .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
		$password .= $chars[ mt_rand(0, strlen($chars) - 1) ];
	}
	return $password;
}

// 生成User密码
function create_user_password ($password, $time, $tokey, $type){
	if ($type == 1) {
		$tk = substr($tokey, 6,10);
		$pass = md5(sha1($password.$time.$tk));
	} elseif ($type == 2) {
		$tk = substr($tokey, 16,8);
		$pass = md5(sha1($time.$password.$tk));
	} elseif ($type == 3) {
		$tk = substr($tokey, 5,9);
		$pass = md5(sha1($password.$tk.$time));
	} elseif ($type == 4) {
		$tk = substr($tokey, 9,7);
		$pass = md5(sha1($password.$time.$tk));
	} elseif ($type == 5) {
		$tk = substr($tokey, 20,6);
		$pass = md5(sha1($tk.$password.$time));
	} else {
		die('加密类型不存在');
	}
	return $pass;
}

// 检测登陆
function checkLogin() {
	if (!isset($_COOKIE['csid']) || empty($_COOKIE['csid']) || !isset($_COOKIE['cstk']) || empty($_COOKIE['cstk'])) {
		header("location:".WWW."/admin/login");exit;
	} else {
		$id = trim(intval($_COOKIE['csid']));
		$tk = trim($_COOKIE['cstk']);
		$user = getUser($id);
		if ($user) {
			$tokey = md5($user['id'].$user['tokey'].$user['eyt_type']);
			if ($tk === $tokey) {
				return true;
			} else {
				header("location:".WWW."/admin/login");exit;
			}
		} else {
			header("location:".WWW."/admin/login");exit;
		}
	}
}

// 获取文章
function getArticle($id) {
	$db = Db::init();
	if ($id == 0) {
		$data = array();
		$sql = "";
	} else {
		$data = array('id' => $id);
		$sql = "";
	}
	
}

// 获取分类
function getCategory(){
	$db = Db::init();
	$data = array();
	$sql = "SELECT `id`, `name`, `pid`, `status`, `add_time`, `last_edit_time` FROM `cs_category` ORDER BY `id` DESC";
	$res = $db->getAll($sql, $data);
	return $res;
}

// function tree(&$list, $pid = 0, $level = 0, $html='--'){
//     static $tree = array();
//     foreach($list as $v){
//         if($v['pid'] == $pid){
//             $v['sort'] = $level;
//             $v['html'] = str_repeat($html,$level);
//             $tree[] = $v;
//             tree($list,$v['id'],$level+1);
//         } 
//     }
//     return $tree;
// }


// 获取某分类的直接子分类
function getSons($catId = 0){
	$categorys = getCategory();
	$sons=array();
	foreach($categorys as $item){
		if($item['pid'] == $catId) {
			$sons[] = $item;
		}
	}
	return $sons;
}

// 获取某个分类的所有子分类
function getSubs($catId=0, $level=1){
	$categorys = getCategory();
	$subs=array();
	foreach($categorys as $item) {
		if($item['pid'] == $catId) {
			$item['level'] = $level;
			$subs[] = $item;
			$subs=array_merge($subs, getSubs($categorys, $item['id'], $level+1));
		}
	}
	return $subs;
}

// 获取某个分类的所有父分类
// 方法一，递归
function getParents($categorys,$catId){
	$tree=array();
	foreach($categorys as $item){
		if($item['id']==$catId){
			if($item['pid']>0)
				$tree=array_merge($tree,getParents($categorys,$item['pid']));
			$tree[]=$item;	
			break;	
		}
	}
	return $tree;
}

// 方法二,迭代
function getParents2($categorys,$catId){
	$tree=array();
	while($catId != 0){
		foreach($categorys as $item){
			if($item['id']==$catId){
				$tree[]=$item;
				$catId=$item['pid'];
				break;	
			}
		}
	}
	return $tree;
}


//测试 部分
// $pdo=new PDO('mysql:host=localhost;dbname=test','root','8888');
// $stmt=$pdo->query("select * from category order by id");
// $categorys=$stmt->fetchAll(PDO::FETCH_ASSOC);

// $result=getSons($categorys,1);
// foreach($result as $item)
// 	echo $item['categoryName'].'<br>';
// echo '<hr>';

// $result=getSubs($categorys,0);
// foreach($result as $item)
// 	echo str_repeat('&nbsp;&nbsp;',$item['level']).$item['categoryName'].'<br>';
// echo '<hr>';

// $result=getParents($categorys,7);
// foreach($result as $item)
// 	echo $item['categoryName'].' >> ';
// echo '<hr>';

// $result=getParents2($categorys,15);
// foreach($result as $item)
// 	echo $item['categoryName'].' >> ';







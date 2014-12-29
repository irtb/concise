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

// 获得专题内容
function getTopic($id){
	$db = Db::init();
	$bindData = array('id' => $id, 'is_open' => 1); 
	$sql = "SELECT * FROM `es_topic` WHERE ( `id` = :id ) AND ( `is_open` = :is_open )";
	$res = $db->getRow($sql, $bindData);
    if(!$res){
    	echo "此专题未打开!";exit;
    }
    return $res['content'];
}

// 学员常见问题
function getComQuestion($listRows) {
    header("Content-Type:text/html; charset=utf-8");
    $data = array('num' => $listRows);
    $db = Db::init();
    $sql = 'SELECT A.`article_id`, A.`title`, A.`add_time` FROM es_article A LEFT JOIN es_article_sort B ON A.`sort_id` = B.`sort_id` WHERE ( B.`sort_id` = 36 ) AND ( A.`is_open` = 1 ) ORDER BY A.`article_order` ASC,A.`article_id` DESC LIMIT :num';
    $res = $db->getAll($sql, $data);

	foreach($res as $key=>$val)
	{
	    $res[$key]['title'] = mb_substr($val['title'], 0, 20, 'utf-8');
	    $res[$key]['html_date'] = date('Ym', strtotime($val['add_time']));
	}
    return $res;
}

// 获取SEO信息
function getseo($sid){
	header("Content-Type:text/html; charset=utf-8");
	$db = Db::init();
	$data = array('s_id' => $sid);
	$sql = 'SELECT `title`, `keywords`, `description` FROM `es_seo` WHERE `s_id` = :s_id';
	$res = $db->getRow($sql, $data);
	$res['seo_title'] = ($res['title'] == '') ? SEO_TITLE : $res['title'].' - '.SEO_TITLE;
	$res['seo_keywords'] = ($res['keywords'] == '') ? SEO_KEYWORDS : SEO_KEYWORDS;
	$res['seo_description'] = ($res['description'] == '') ? SEO_DESCRIPTION : $res['description'];
	return $res;
}

// 获取案例信息
function getcase(){
	header("Content-Type:text/html; charset=utf-8");
	$db = Db::init();
	$data = array('aid' => $aid);
	$sql = 'SELECT A.`article_id`,C.`content` FROM `es_article` A LEFT JOIN `es_article_content` C ON A.`article_id` = C.`article_id` WHERE ( A.`article_id` = :aid ) AND ( A.`sort_id` = 122 ) AND ( A.`is_open` = 1 )';
	$res = $db->getRow($sql, $data);
	if (empty($res)) {
		header('location:http://www.eswine.com');
	} else {
		return $res;
	}
}

// 获取广告信息
function getAd($ad_classid){
	header("Content-Type:text/html; charset=utf-8");
	$db = Db::init();
	$data = array('ad_classid' => $ad_classid);
	$sql = 'SELECT * FROM `es_ad` WHERE ( `ad_classid` = :ad_classid ) ORDER BY `add_time` DESC';
	$res = $db->getRow($sql, $data);

	if (empty($res)) {
		header('location:http://www.eswine.com');
	} else {
		return $res;
	}
}

// 获取新闻列表
function getNews($sid, $p, $url){
	header("Content-Type:text/html; charset=utf-8");
	$db = Db::init();
	$count_data = array('sid' => $sid);
	$count_sql = "SELECT COUNT(A.`article_id`) AS `c` FROM `es_article` A LEFT JOIN `es_article_sort` B ON A.`sort_id` = B.`sort_id` WHERE ( B.`sort_id` = :sid ) AND ( A.`is_open` = 1 )";
	$res_count = $db->getRow($count_sql, $count_data);
	$count = intval($res_count['c']);

	$data = array('sid' => $sid, 'sr' => ($p-1)*10, 'er' => 10);
	$sql = "SELECT A.`article_id`, A.`title`, C.`content`, A.`description`, A.`upd_date`, A.`add_time`, A.`link_url`, A.`page_control` FROM `es_article` A LEFT JOIN `es_article_sort` B ON A.`sort_id` = B.`sort_id` LEFT JOIN `es_article_content` C ON A.`article_id` = C.`article_id` WHERE ( B.`sort_id` = :sid ) AND ( A.`is_open` = 1 ) ORDER BY A.`article_order` ASC, A.`article_id` DESC LIMIT :sr, :er";
	$list = $db->getAll($sql, $data);

	foreach($list as $key => $val) {
		$pic_data = array('aid' => $val['article_id']);
		$pic_sql = "SELECT `article_pic`, `pic_desc` FROM `es_article_pic` WHERE `article_id` = :aid ORDER BY `pic_order` LIMIT 2";
		$piclist = $db->getAll($pic_sql, $pic_data);
		foreach($piclist as $key_1 => $val_1) {
			$piclist[$key_1]['article_pic'] = $val_1['article_pic'];
			$piclist[$key_1]['pic_desc'] = $val_1['pic_desc'];
		}
	    $list[$key]['piclist'] =$piclist;
	    $list[$key]['upd_date'] = date('Y-m-d', strtotime($val['upd_date']));
	    $list[$key]['html_date'] = date('Ym', strtotime($val['add_time']));
	    $list[$key]['content'] =mb_substr(str_replace('　','',str_replace('&nbsp;','',strip_tags($val['content']))), 0, 200, 'utf-8')."......";
		//$list[$key]['description'] = $val['description'];
		$list[$key]['link_url'] = $val['link_url'];
		$list[$key]['page_control'] = $val['page_control'];
	}
	$t = new Page(10, $count, $p, 5, $url);
	$page = $t->subPageCss2();
	$res = array('list' =>$list, 'page' => $page);
	return $res;
}

// 获取奖学金列表
function getJiangxuejin($sid, $atid){
	header("Content-Type:text/html; charset=utf-8");
	$db = Db::init();
	$list = array();
	
	$data = array('sid' => $sid);
	$sql = "SELECT A.`article_id`, A.`title`, A.`description`, A.`expland`, A.`add_time`, B.`attr_value`, C.`article_pic`, C.`pic_desc` FROM `es_article` A LEFT JOIN `es_article_attr` B ON A.`article_id` = B.`article_id` LEFT JOIN `es_article_pic` C ON A.`article_id` = C.`article_id` WHERE A.`sort_id` = :sid ORDER BY A.`article_order` ASC";
	$res = $db->getAll($sql, $data);

	$year_data = array('attr_id' => $atid);
	$year_sql = "SELECT `attr_value` FROM  `es_article_attr` WHERE `attr_id` = :attr_id GROUP BY `attr_value` ORDER BY `attr_value` DESC";
	$year = $db->getAll($year_sql, $year_data);

	foreach ($year as $key => $val) {
		foreach ($res as $k => $v) { 
			if ($v['attr_value'] == $val['attr_value']) {
				$list[$val['attr_value']]['date'] = array('month' => substr($v['attr_value'], -2), 'year' => substr($v['attr_value'], 0, 4));
				$v['time'] = substr($v['add_time'], 0, 4).substr($v['add_time'], 5, 2);
				$list[$val['attr_value']]['info'][] = $v;
			}
		}
	}
	return $list;
}



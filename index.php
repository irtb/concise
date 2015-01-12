<?php 
include("./Core/core.php");
// $db = Db::init();
// $tokey = create_password(32);
// $data = array('tokey' => $tokey, 'status' => 1, 'add_time' => time(), 'dis_time' => time());
// $res = $db->addRow('cs_tokey', $data);


dump(getTokey());

function create_password($pw_length = 8) {
    $randpwd = '';
    for ($i = 0; $i < $pw_length; $i++) {
        $randpwd .= chr(mt_rand(33, 126));
    }
    return $randpwd;
}

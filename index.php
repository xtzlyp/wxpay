<?php 
/**
*桃花源专题
*/
require_once('../../../includes/global_top.php');
require_once(WWW_ROOT_PATH . '/parties/app/peach_garden/class/peach_garden.class.php');
require_once(WWW_ROOT_PATH . '/includes/MySmarty.class.php');
if(!$SESSION->is_login()){
	header('Location: /login/index.php?pre_url='.SITE_URL.$_SERVER['REQUEST_URI']);
	exit();
}
if(get_req_value('a')){
	$peach=new peach();
	$method = get_req_value('a');
	$peach->$method();
	exit();
}


$smarty = new MySmarty('parties/app/peach_garden',true);
$uid = $USER->uid;
$nickname = $USER->nickname;
$sex = $USER->sex ? $USER->sex : m;
$need_num = $sex=='m' ? 18 : 13;

$today_zero=strtotime('today');
$C_time=time()-($today_zero+19*3600); 
$C_times=time()-($today_zero+24*3600);
if($C_time>0&&$C_times<0){
	$need_num = $sex=='m' ? 13 : 13;
}


$userlist=get_users($need_num,$uid,$sex,'zt-peach_garden','pmtq-yy-peach_garden',$disp=1000000);
if(is_array($userlist['data'])){
	$smarty->assign('userOne',$userlist['data'][0]);
	$smarty->assign('userTwo',$userlist['data'][1]);
	$smarty->assign('userThree',$userlist['data'][2]);
	unset($userlist['data'][0]);
	unset($userlist['data'][1]);
	unset($userlist['data'][2]);
	$smarty->assign('userlist',array_values($userlist['data']));
}else{
	$smarty->assign('nouser',1);
}
$usertype=$USER->new_msg==10?1:2;
$smarty->assign('usertype',$usertype);
$smarty->assign('uid',get_disp_uid($USER->uid));
$smarty->assign('nickname',$nickname);
$smarty->display('index.html');


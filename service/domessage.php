<?php

//require_once $_SERVER['DOCUMENT_ROOT'].'/Blog/lib/Db.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/lib/Db.php';

//登录
$username = $_POST['username'];
$email = $_POST['email'];
$content = $_POST['content'];
$time = time();
$db = new Db();

//$username =258;
$db->table('message')->insert(array('name'=>$username,'email'=>$email,'content'=>$content,'time'=>$time));

if(!$username){
	exit(json_encode(array('code'=>1,'msg'=>'请输入昵称')));
}
if(!$content){
	exit(json_encode(array('code'=>1,'msg'=>'请留言')));
}


//账号密码正确
exit(json_encode(array('code'=>0,'msg'=>'留言成功')));
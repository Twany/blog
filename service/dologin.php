<?php

//require_once $_SERVER['DOCUMENT_ROOT'].'/Blog/lib/Db.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/lib/Db.php';

//登录
$username = $_POST['username'];
$password = $_POST['password'];
$db = new Db();

//$username =258;
$user = $db->table('admin')->where(array('name'=>$username))->item();

if(!$user){
	exit(json_encode(array('code'=>1,'msg'=>'用户不存在')));
}
if($password != $user[0]['password']){
	exit(json_encode(array('code'=>1,'msg'=>'密码错误')));
}

//设置session
session_start();
$_SESSION['user'] = $user;

//账号密码正确
exit(json_encode(array('code'=>0,'msg'=>'登录成功')));
<?php
session_start();
$_SESSION['captcha'] = $_POST['captcha'];
if($_SESSION['captcha'] !=$_SESSION['tureCaptcha']){
	exit(json_encode(array('code'=>1,'msg'=>'验证码错误')));
}
exit(json_encode(array('code'=>0,'msg'=>'验证码正确')));
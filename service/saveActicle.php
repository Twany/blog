<?php
session_start();
$user = $_SESSION['user'] ? $_SESSION['user']:false;
if(!$user){
	exit(json_encode(array('code'=>1,'msg'=>'请登录..')));
}

//插入的标题和内容
$data['title'] = $_POST['title'];
$data['content'] = htmlspecialchars($_POST['content']);
$data['addTime'] = time();
//要插入的表
$data['cid'] = $_POST['cid']; 

if(!$data['title']){
	exit(json_encode(array('code'=>1,'msg'=>'请输入标题')));
}
if(!$data['content']){
	exit(json_encode(array('code'=>1,'msg'=>'请输入文章内容')));
}

require_once $_SERVER['DOCUMENT_ROOT'].'/lib/Db.php';
$db = new Db();

$db->table('acticle')->insert($data);

exit(json_encode(array('code'=>0,'msg'=>'保存成功')));




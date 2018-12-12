<?php
require_once('lib/Db.php');
$db = new Db();

$data = $db->table('message')->lists();


foreach($data as $key){
	foreach($key as $k=>$val){
		if($k == 'name'){
			$name[] = $val;
		}
		if($k == 'email'){
			$email[] = $val;
		}
		if($k == 'content'){
			$content[] = $val;
		}
		if($k == 'time'){
			$time[] = $val;
		}
	}
}
$num = count($name);
?>


<!doctype html>
<html>
<head>
	<meta name="viewport" content="width=device-width,initial-scale=1">
	    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="shortcut icon" href="config/images/1.icon" type="image/x-icon">

<script src="config/plugins/jquery.min.js"></script>
<script src="config/plugins/dist/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="config/plugins/dist/css/bootstrap.min.css">
<script src="config/js/modal.js"></script>	
</head>
	<style>
		*{margin: 0}
		.head{background: #FAFAFA;width: 100%;height: 250px;font-size: 3rem;text-align: center;}
		
		.body{		
			height: 500px;
			width: 800px;
			margin: auto
		}
		.left{
			height: 120px;width: 100px;float: left;
		}
		.right{
			width: 700px;float: right;padding-left: 20px;padding-top: 5px;height: 120px
		}
		.foot{		
			height: 500px;
			width: 800px;
			margin: auto
		}
		img{
			border-radius: 50%;margin: auto
		}
		.form-group{
			margin-top: 20px
		}
		.back:hover{
			width: 90px
		}
	</style>
<body>
	<div class="head">
		<a href="http://blog.com"><img src="config/images/back.png" alt="" style="position: absolute;left: 20px;top: 20px" width="80px" class="back"></a>
		<br><br>
		<p>留言板</p>
		<br>
		<p style="font-weight: 100;font-size: 15px">2 0 1 8 年 1 1 月 1 9 日</p>	
	</div>
	
	<div class="body">
		<br>
		<p style="color: #666;border-left:medium solid #666">&nbsp;写一些看不见的话</p>
		<br>
		<p style="color:


#B0E0E6;font-size: 25px">添加新评论</p>
		
		

	
  <div class="form-group">
    <label for="exampleInputEmail1">昵称</label>
    <input type="text" class="form-control" id="username" placeholder="您的姓名">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">邮箱</label>
    <input type="email" class="form-control" id="email" placeholder="如何联系到您（选填）">
  </div>
	<label for="exampleInputPassword1">留言</label>
	<textarea class="form-control" rows="3" id="content" placeholder="您想说的话..."></textarea>
 <br>
  <button type="submit" class="btn btn-default btn-block" onclick="dosubmit();">提交</button>
	
	</div>
	<div class="foot">
		
		<p>已有 <?php echo $num; ?> 条评论</p>
		
		<?php for($i=0;$i<$num;$i++){ ?>
		<div style="margin-top: 20px"> 
			
		<div class="left" align="center">
			<img src="config/images/img.jpg" width="80px">
		
		
		</div>
		
		<div class="right">
			
			<p style="color:red;font-size: 18px"><?php echo $name[$i]; ?></p>
			<p style="color: #C5C5C5"><?php echo date('Y-m-d H:i:s',$time[$i]); ?></p>
			<p style="font-size: 20px;font-weight: 100"><?php echo $content[$i]; ?></p>
		
		</div>
	
		</div>
		<?php } ?>
		
	</div>
	
</body>
</html>
<script>
	function dosubmit(){
		let username = $('#username').val();
		let email = $('#email').val();
		let content = $('#content').val();
		if(username == ''){
			UI.alert({msg:'请输入昵称',icon:'error'});
			return;
		}
		if(username == ''){
			UI.alert({msg:'请留言',icon:'error'});
			return;
		}		
		$.post('http://blog.com/service/domessage.php',
			  {username:username,email:email,content:content},
			  function(res){
			if(res.code == 1){
				UI.alert({msg:res.msg,icon:'error'});
			}else{
				UI.alert({msg:'留言成功',icon:'ok'});
				//刷新父级页面
				setTimeout(function()
						   {window.location.reload();},1000);								
			}
			
		},'json');
	}

</script>




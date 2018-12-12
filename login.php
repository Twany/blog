<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>博客</title>
</head>
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
<body>
<h1 style="font-family:  '站酷文艺体';color:#4B3334;font-weight: 500;margin: 0" class="text-center">欢迎登录</h1>
	<hr style="margin: 0">
	<br>
				<div class="input-group">
					<span class="input-group-addon">账号：</span>
					<input type="text" class="form-control" id="username">
				  
				</div>
				  <br>
				<div class="input-group">
					<span class="input-group-addon">密码：</span>
					<input type="password" class="form-control" id="password">
				</div>	
	<br>
					<button class="btn btn-primary btn-block" onclick="dologin();" type="submit">登录</button>
</body>
</html>
<script>
	function dologin(){
	let username = $('#username').val();
	let password = $('#password').val();
	if(username == ''){
		UI.alert({msg:'请输入账号',icon:'error'});
		return;
	}
	if(password == ''){
		UI.alert({msg:'请输入密码',icon:'error'});
		return;
	}
		//#.post('url',参数,处理函数)
	//$.post('http://39.107.127.186/Blog/service/dologin.php',{username:username,password:password},function(res){
	//$.post('http://39.107.127.186/Blog/service/dologin.php',
	$.post('http://blog.com/service/dologin.php',
		   {username:username,password:password},
		   function(res){
			if(res.code > 0){
				UI.alert({msg:res.msg,icon:'warm'});
			}else{
				UI.alert({msg:res.msg,icon:'ok'});
				//刷新父级页面
				setTimeout(function()
						   {parent.window.location.reload();},1000);				
			}
			},'json');

	}
	
</script>


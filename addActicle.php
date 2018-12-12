<?php 
require_once $_SERVER['DOCUMENT_ROOT'].'/lib/Db.php';
$db= new Db();

$date = $db->table('cate')->lists();

//遍历标签
foreach($date as $key=>$value){
	foreach($value as $k=>$val){
		if($k == 'title'){
			$title[] = $val;
		}
	}
}

//标签总数
$num = count($title);

?>
<!doctype html>
<html>
	<title></title>
</head>
	<meta name="viewport" content="width=device-width,initial-scale=1">
	    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
<script src="config/plugins/jquery.min.js"></script>
<script src="config/plugins/dist/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="config/plugins/dist/css/bootstrap.min.css">
<script src="config/plugins/wangEditor.min.js"></script>
<script src="config/js/modal.js"></script>
<body>
	<div class="input-group">					
		<span class="input-group-addon">标题：</span>
		<input type="text" class="form-control" id="title" placeholder="请输入标题">				  
	</div>
	<br>
	
	<!--分类-->
	<div class="input-group">
		<span class="input-group-addon">分类：</span>
		<select class="form-control" id="cates">
			<?php for($i=0;$i<$num;$i++){  ?>
			<option value="<?php echo $title[$i];?>"> <?php echo $title[$i]; ?></option>
			<!--<option value="Html5,CSS">Html5,CSS</option>
			<option value="Javascript">Javascript</option>
			<option value="PHP">PHP</option>
			<option value="Bootstrap">Bootstrap</option>
			<option value="Vue.js">Vue.js</option>
			<option value="Thinkphp5.1">Thinkphp5.1</option>
			<option value="C++">C++</option>
			<option value="thinking">个人感悟</option>-->
			<?php } ?>
		</select>
	</div>
	<br>
	
	<!--编辑器-->
	<div class="input-group">
		
		<span class="input-group-addon">内容：</span>
		<!--<textarea class="form-control" rows="6" id="content" placeholder="请输入内容..."></textarea>-->
		<div id="editor"></div>
	</div>
	
	<br>
	
	<!--验证码-->
	<div class="col-sm-2">
	<img src="http://blog.com/service/checkCode.php" onClick="this.src='http://blog.com/service/checkCode.php';">
	</div>
	<!--输入验证码-->
	<div class="col-sm-2">
		<input type="text" class="form-control" id="captcha">
	</div>
	
	<!--保存-->
	<div class="col-sm-8">
	<button class="btn btn-block btn-primary" onclick="save();" type="submit">保存</button>
		</div>
	
</body>
</html>
<script>
	//编辑器使用
		var editor;
		var E = window.wangEditor;
		editor = new E('#editor');
		editor.customConfig.zIndex = 100;
		editor.customConfig.uploadImgShowBase64 = true;
		editor.create();
		
	//验证码

	
	//保存博客
	function save(){
		//验证码
		let captcha = $('#captcha').val();
		$.post('http://blog.com/service/captcha.php',{captcha:captcha},function(res){
			//错误的验证码	
			if(res.code == 1){
				UI.alert({msg:res.msg});
				
				return;
			}
		},'json');		
		//保存文章
		let content = editor.txt.html();
		//let content = $('#content').val();
		let title = $('#title').val();
		//注意select选中的值
		let cid = $('#cates option:selected').val();
		
		if(title == ''){
			UI.alert({msg:'请输入标题'});
			return;
		}
		if( content == '<p><br></p>'){
			
			UI.alert({msg:'请输入博客内容'});
			return;
		}

		
		$.post('http://blog.com/service/saveActicle.php',{content:content,title:title,cid:cid},function(res){

			if(res.code == 1){
				UI.alert({msg:res.msg,icon:'warm'});
			}
			if(res.code == 0){
				UI.alert({msg:res.msg,icon:'ok'});
				setTimeout(function(){window.location.reload();},1000);
			}
		},'json');
	}

    
</script>	

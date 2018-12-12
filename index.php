<?php



//把格林威治标准时间变为北京时间
date_default_timezone_set("PRC"); 
session_start();
$user = isset($_SESSION['user'])?$_SESSION['user']:false;
//print_r($_SERVER['DOCUMENT_ROOT']);
//require_once $_SERVER['DOCUMENT_ROOT'].'/lib/Db.php';
require_once ('lib/Db.php');
$db = new Db();

$cate = $db->table('cate')->lists();

foreach($cate as $cate){
	foreach($cate as $key=>$value){
		if($key == 'title'){
			$cates[] = $value;
		}
	}
}

$cid = isset($_GET['cid'])?$_GET['cid']:'0';
$where = [];
if($cid){
	$where['cid'] = $cid;
}
$page = isset($_GET['page'])?$_GET['page']:1;
$pageSize = 3;
 $data = $db->table('acticle')->where($where)->order('addTime desc')->field('*')->pages($page,$pageSize);
//echo '<pre>';
//print_r($data);
foreach($data['data'] as $key=>$value){
	$num = $key;
	foreach($value as $k=>$val){
		
		if($k == 'title'){
			$title[] = $val;
			//echo $val;
		}
		if($k == 'content'){
			$content[] =$val;
		}
		if($k == 'cid'){
			$cid1[] = $val;
		}
		if($k == 'addTime'){
			$time[] = $val;
		}
		//echo '<br>';
	}
}

//echo $key;
//echo '=================<br>';
//echo $data['total'];
//print_r($time);
//print_r($content);
/*for($i=0;$i<$pageSize;$i++){
	echo $title[$i];
	echo '<br>';
	echo $content[$i];
	echo '<br>';
	echo $cid[$i];
	echo '<br>';
	echo $time[$i];
	echo '<br>========<br>';
}
	*/

//网站访客记录
$filename = 'hello.txt';
$max = 9;
if(!is_file($filename)){
	touch('hello.txt');
	$file = fopen($filename,'rb+');
	fwrite($file,1);
	fclose($file);
	return;
}else{
	$file = fopen($filename,'r');
	$jishu = fread($file,$max);
	fclose($file);
	$file = fopen($filename,'w');
	$jishu++;
	fwrite($file,$jishu);
	fclose($file);
}


?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>{渐悟}</title>
</head>
	<meta charset="UTF-8">
<!--	<meta name="viewport" content="width=device-width,initial-scale=1">
	 <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">-->
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="shortcut icon" href="config/images/1.icon" type="image/x-icon">

<script src="config/plugins/jquery.min.js"></script>
<script src="config/plugins/dist/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="config/plugins/dist/css/bootstrap.min.css">

<script src="config/js/modal.js"></script>	
<link rel="stylesheet" href="config/css/index.css">
<body style="background: #f1f1f1">
	<!--背景音乐-->
	<audio autoplay src="回音哥 - 后来 - 翻唱.mp3">  </audio>
	<!--导航-->
	
	<ul class="nav navbar-nav navbar-right" style="font-family:'站酷文艺体', '站酷快乐体2016修订版';margin: 0 ">
        <li>
			<?php if($user){ ?>
			<a href="#" class="btn" style="color: beige" onclick="logout()">退出</a>
			<?php }else{?>
			<a href="#" class="btn" style="color: beige" onclick="login()">登录</a>
			<?php } ?>
			
		</li>
		
       	<li><a href="#" class="btn" style="color: beige" onClick="addActicle()">发表文章</a></li>
        <li><a href="http://blog.com/message.php" class="btn" style="color: beige">给我留言</a></li>
                            
 
		<!--搜索-->
<!--		<form class="navbar-form navbar-left" style="margin-right: 20px">
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Search" style="width:150px">
        </div>
        <button class="btn btn-default">Go</button>
      </form>-->

                           
	</ul>
	
	<!--巨幕-->
	<div class="jumbotron" style="background:url(config/images/jumu.jpg);background-size: 100%">
					
		<h1 style="color: aliceblue;margin-left: 20px;font-family: '站酷快乐体2016修订版'">渐悟</h1>
					<h2 style="color: aliceblue;margin-left: 20px;font-family:'站酷快乐体2016修订版'"><span class="glyphicon glyphicon-pencil"></span> 做自己认为正确的事情</h2>
				
	</div>
	
	<!--主体-->
	<div class="container-fluid">
		
		
		<div class="row">
			<!--左侧主体-->
			 <!--此处用到了响应式布局-->
			<div class="col-md-6 col-sm-6 col-md-offset-1 col-sm-offset-1" style="padding: 10px;min-height: 740px">
				<?php for($i=0;$i<=$num;$i++){ ?>
				<div class="panel" style="background: lightblue">
					<div class="panel-heading">
						<h2><?php echo $title[$i]; ?></h2>
					</div>
					
						
						<div class="dropdown">
						  <button class="btn dropdown-toggle btn-block" id="dropdownMenu1" data-toggle="dropdown" style="background: #C0E4EC" >
							  <strong>详细内容</strong></br>
							<span class="caret"></span>
						  </button>
						  <button class="dropdown-menu btn btn-block">
						  	<div class="panel-body">
								<p><?php echo html_entity_decode($content[$i]); ?></p>
							  
							</div>
						  </button>
						
					</div>
					<div class="panel-footer"  style="background: lightblue">
						<p style="margin: 0">
							<?php echo '发表时间：'.date('Y-m-d H:i:s',$time[$i]);echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;归档：['.$cid1[$i].']'; ?>
						</p>
					</div>
				</div>
				<?php } ?>
			
				
				
								
				<!--页脚-->
				<nav class="text-center">
					<ul class="pagination">
						<?php print_r($data['pages']); ?>
					</ul>
				
				</nav>
			</div>
			
			<!--右侧菜单-->
			<div class="col-md-4 col-sm-4 col-md-offset-1 menu">
						

				<h3>标签云</h3>
				<div class="biaoqian">
					<span class="label label-info" >
					<a href="http://blog.com/index.php">首页</a>
					</span>	
<!-- 服务器
						<span class="label label-info"><a href="/Blog/index.php">首页</a></span>
						<span class="label label-info"><a href="/Blog/index.php?cid=Html5,CSS">Html5，CSS</a></span>
						<span class="label label-danger"><a href="/Blog/index.php?cid=Javascript">Javascript</a></span>
						<span class="label label-default"><a href="/Blog/index.php?cid=PHP">PHP</a></span>
						<span class="label label-info"><a href="/Blog/index.php?cid=Bootstrap">Bootstrap</a></span>
						<span class="label label-warning"><a href="/Blog/index.php?cid=Vue.js">Vue.js</a></span>
						<span class="label label-danger"><a href="/Blog/index.php?cid=Thinkphp5.1">Thinkphp5.1</a></span>
						<span class="label label-success"><a href="/Blog/index.php?cid=C++">C++</a></span>
-->
				<?php for($i=0;$i<count($cates);$i++){ ?>		
					
					
					<!--产生不同的颜色标签-->
					<span class="label 
								 <?php
							 $array = array('label-info','label-danger','label-primary','label-success','label-warning');
							 $a = array_rand($array);
							 
							 echo $array[$a] ?>">
						<a href="http://blog.com/index.php?cid=<?php echo $cates[$i]  ?>" style="text-decoration: none"><?php echo $cates[$i]  ?></a>
					</span>

				<?php } ?>
				</div>				
				
				
				<h3>作品集</h3>
				<div>
					<ul class="list-group">
						<li class="list-group-item"><a href="">个人博客系统</a></li>
						<li class="list-group-item"><a href="">网站管理后台</a></li>
						<li class="list-group-item"><a href="">“同学你好”小程序</a></li>
						
					</ul>

				</div>
				
				<!--返回顶部按钮-->
				<!--<a class="btn btn-default" id="back" href="" style="position: fixed;right: 20px"><img src="config/images/3.svg" alt=""></a>-->
				<h3>关于我</h3>
						
						<ul class="list-group">
						<li class="list-group-item"><a href=""><span class="glyphicon glyphicon-sunglasses"></span> :渐悟</a></li>
						<li class="list-group-item"><a href=""><span class="glyphicon glyphicon-grain"></span> :www.itwany.com</a></li>
						<li class="list-group-item"><a href=""><span class="glyphicon glyphicon-education"></span> :小白程序员</a></li>						
						<li class="list-group-item"><a href="#" onclick="phoneMe();"><span class="glyphicon glyphicon-envelope"></span> :联系我</a></li>						
						</ul>

			
		
			</div>
			
		</div>
		<!--底部-->
		<div class="row" style="background: RGB(202,202,202)">
			<div class="col-md-12 col-sm-12 text-center">
				<br>
				<br>
				<p class="text-center" style="color: #666">Welcome，您是本站的第<?php echo $jishu; ?>位访客</p>
				<p class="text-center" style="color: #666">Copyright &copy; Powered by 渐悟</p>
				<br>
				
			</div>
		</div>
	</div>
			<!-- Button trigger modal -->
		<!--<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
		  Launch demo modal
		</button>-->

		<!-- Modal -->
<!---->
</body>
</html>
<script type="text/javascript">
	//$('.cates').attr("class",'label label-danger cates');
	
	//$('#myModal').modal({backdrop:'static'});
	//$('#myModal').modal('show');
	function phoneMe(){
		//UI.open({title:'微信扫描二维码',url:'http://39.107.127.186/Blog/phoneMe.php',width:585,height:400});
		UI.open({title:'微信扫描二维码',url:'http://blog.com/phoneMe.php',width:585,height:400});
	}
	
	
	//登录
	function login(){
		//UI.alert({msg:'登录失败',icon:'error'});

		//UI.open({title:'登录'});
		//UI.alert({title:'标题'});
		//UI.open({title:'登录',url:'http://39.107.127.186/Blog/login.php',width:400,height:240});
		UI.open({title:'登录',url:'http://blog.com/login.php',width:400,height:240});
	}
	//退出登录
	function logout(){
		//$.get('http://39.107.127.186/Blog/service/logout.php',{},function(res){
		$.get('http://blog.com/service/logout.php',{},function(res){
			
				UI.alert({title:'退出',msg:'退出成功，正在跳转...'});
				setTimeout(function(){window.location.reload();},1000);
			
		})
	}
	//发表文章
	function addActicle(){
		<?php if(!$user){ ?>
		UI.alert({msg:'请先登录！'});
		return;
		<?php  }?>
		//UI.open({title:'发表文章',url:'http://39.107.127.186/Blog/addActicle.php',width:850,height:600})
		UI.open({title:'发表文章',url:'http://blog.com//addActicle.php',width:850,height:600})
	}

	
	
	
	/*返回顶部*/
	$(function(){
		$(window).scroll(function(){
			if($(window).scrollTop()>100){
				$('#back').fadeIn();
			}else{
				$('#back').fadeOut();
			}
		});
	});

	
	[a,b,c,d,e]
	
	
	
	
	
</script>
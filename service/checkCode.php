<?php
//验证码


//创建画布
$image = imagecreatetruecolor(100,38);

//设置画布颜色
$bgcolor = imagecolorallocate($image,255,255,255);

//用背景色填充画布
imagefill($image,0,0,$bgcolor);

//在画布上写字
$captcha = '';
$code ='abcdefghijk012345789';
for($i=0;$i<4;$i++){
	//设置画笔颜色
	$fontColor = imagecolorallocate($image,rand(1,120),rand(1,120),rand(1,120));
	$captcha .= $code[rand(0,19)];
	
}
imagestring($image, 20, 20, 12,$captcha,$fontColor);

//加干扰点
for($i=0;$i<200;$i++){
	$pointColor = imagecolorallocate($image,rand(50,180),rand(0,180),rand(0,180));
	imagesetpixel($image,rand(1,99),rand(1,36),$pointColor);
}

//加干扰线
for($i=0;$i<3;$i++){
	$lineColor = imagecolorallocate($image,rand(50,180),rand(0,180),rand(0,180));
	imageline($image,rand(1,99),rand(1,36),rand(1,99),rand(1,36),$lineColor);
}

//输出图片
//1.修改输出格式为图片
header("content-type:image/png");
imagepng($image);
	

session_start();
$_SESSION['tureCaptcha'] = $captcha;


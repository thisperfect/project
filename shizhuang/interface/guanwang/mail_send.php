<?php
/**
* ==============================================
* Copyright (c) 2015 All rights reserved.
* ----------------------------------------------
* 邮箱发送
* ==============================================
* @date: 2016-7-20
* @author: luoxue
* @version:
*/
include_once 'config.php';

$post = serialize($_POST);
write_log(ROOT_PATH."log","mail_sent_all_log_","post=$post, ".date("Y-m-d H:i:s")."\r\n");

$email = $_POST['email'];
$gameId = $_POST['game_id'];
$sign = $_POST['sign'];
$params = array(
		'email',
		'game_id',
		'sign'
);
for ($i = 0; $i< count($params); $i++){
	if (!isset($_POST[$params[$i]])) {
		exit(json_encode(array('status'=>1, 'msg'=>'Missing '.$params[$i])));
	} else {
		if(empty($_POST[$params[$i]]))
			exit(json_encode(array('status'=>1, 'msg'=>$params[$i].' should not be empty.')));
	}
}
if (!eregi('^[_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,3}$',$email))
	exit(json_encode(array('status'=>1, 'msg'=>'email format error.')));
$appKey = $key_arr['appKey'];
if(!$appKey)
	exit(json_encode(array('status'=>1, 'msg'=>'appkey error.')));
$array['email'] = $email;
$array['game_id'] = $gameId;
ksort($array);
$md5Str = http_build_query($array);
$mySign = md5(urldecode($md5Str).$appKey);
if($mySign != $sign)
	exit(json_encode(array('status'=>1, 'msg'=>'sign error.')));

$conn = SetConn('88');
$sql = "select * from web_message where game_id='$gameId' and username='$email' limit 1";
if(false == $query = mysqli_query($conn,$sql))
	exit(json_encode(array('status'=>1, 'msg'=>'web server sql error.')));

$rs = @mysqli_fetch_assoc($query);
$nowTime = time();
if(!empty($rs['addtime'])){
	if($nowTime-$rs['addtime'] < 60)
		exit(json_encode(array('status'=>1, 'msg'=>'can not repeatedly transmitted within 60 seconds.')));
}
$code = rand(1000,9999);
$iSql= "insert into web_message(game_id, username, code, addtime) values('$gameId', '$email', '$code', '$nowTime')";
if(false == mysqli_query($conn,$iSql))
	exit(json_encode(array('status'=>1, 'msg'=>'web server sql error.')));


$title = '海牛网络登陆信';
$message = "亲爱的$email<br />
您的邮箱登陆码是：$code<br />
此登陆码在15分钟内有效! <br /><br />

温馨提示：<br />
* 本邮件为系统自动发送，不受理客户在线直接回复。<br />
* 您可以使用客户服务电话0591-87678008联系我们。再次感谢您使用海牛提供的服务！<br /><br />

福州海牛游戏软件开发有限公司版权所有";

if(SendMail($email, $title, $message))
	exit(json_encode(array('status'=>0, 'msg'=>'success')));
else
	exit(json_encode(array('status'=>1, 'msg'=>'fail')));

function SendMail($address,$title,$message){
	include_once 'PHPMailer/class.phpmailer.php';
	$mail=new PHPMailer();
	// 设置PHPMailer使用SMTP服务器发送Email
	$mail->IsSMTP();
	// 设置邮件的字符编码，若不指定，则为'UTF-8'
	$mail->CharSet='UTF-8';
	// 添加收件人地址，可以多次使用来添加多个收件人
	$mail->AddAddress($address);
	// 设置邮件正文
	$mail->Body=$message;
	// 设置邮件头的From字段。
	$mail->From='418209006@163.com';
	// 设置发件人名字
	$mail->FromName='落雪凝梦';
	// 设置邮件标题
	$mail->Subject=$title;
	// 设置SMTP服务器。
	$mail->Host='smtp.163.com';
	// 设置为"需要验证"
	$mail->SMTPAuth=true;
	// 设置用户名和密码。
	$mail->Username='418209006@163.com';
	$mail->Password='fdk87ta6hy09g3z';
	// 发送邮件。
	return($mail->Send());
}
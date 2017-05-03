<?php
header("Content-type: text/html; charset=utf-8");

session_start();
$_SESSION['ecode']=rand(1000,9999);

$email = $_POST['email'];


set_time_limit(0);//设置脚本执行超时时间
include("./phpmailer/PHPMailerAutoload.php");

$mail = new PHPMailer;
//https://
//邮件服务器信息配置
$mail -> ISSMTP();  //设置邮件发送协议 smtp|pop3|imap
$mail -> CharSet = "utf-8";  //设置邮件编码
$mail -> SMTPSecure = "ssl";  // SMTP 安全协议
$mail -> Port = 465;          // 邮件端口
$mail -> Host = "smtp.qq.com"; // 使用的邮件服务器
$mail -> SMTPAuth = true;  //设置phpmail发送邮件是否需要验(username&password)
if($mail -> SMTPAuth){
    $mail -> Username = "574969406@qq.com";
    $mail -> Password = 'jivwhevksvuwbcch';//密码
}
$mail -> From = "574969406@qq.com";    //来源from
$mail -> IsHTML(true); // 是否发送html邮件

//$mail->AddAttachment('./email.txt','你中奖啦.txt'); // 添加附件,并指定名称
//发送邮件信息
$mail -> Addaddress($email); // 收件人
$mail->FromName = 'masker';//发送人姓名
$mail -> Subject = '邮箱验证';   // 标题
$mail -> Body = $_SESSION['ecode'];// 内容
if($mail->send()){
    echo '1';
}else{
    echo '2';
}




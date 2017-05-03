<?php
function tree($arr,$pid=0,$level=0,$field=null,$type=true){
    if(!$field){
        $field=['id'=>'id','pid'=>'pid'];
    }
    if(!isset($arr[0][$field['pid']])) return "没有{$field['pid']}字段";
    if(!isset($arr[0][$field['id']])) return "没有{$field['id']}字段";
    static $res=[];
    if($type){
        $res=[];
    }
    foreach ($arr as $v){
        if($v[$field['pid']]==$pid){
            $v['level']=$level;
            $res[]=$v;
            tree($arr,$v[$field['id']],$level+1,null,$type=false);
        }
    }
    return $res;
}

function sendmail($email,$sendemail){
    $_SESSION['ecode']=rand(1000,9999);

    set_time_limit(0);//设置脚本执行超时时间
    include("/wwwroot/138/obj/Public/phpmailer/PHPMailerAutoload.php");

    $mail = new PHPMailer;
    //https://
    //邮件服务器信息配置
    $mail -> ISSMTP();  //设置邮件发送协议 smtp|pop3|imap
    $mail -> CharSet = "utf-8";  //设置邮件编码
    $mail->SMTPSecure = "ssl";  // SMTP 安全协议
    $mail -> Port = 465;          // 邮件端口
    $mail -> Host = "smtp.qq.com"; // 使用的邮件服务器


    $mail -> SMTPAuth = true;  //设置phpmail发送邮件是否需要验(username&password)
    if($mail -> SMTPAuth){
        $mail -> Username = $sendemail;
        $mail -> Password = 'qttuucopbjmpbddf';//密码
    }
    $mail -> From = $sendemail;    //来源from
    $mail -> IsHTML(true); // 是否发送html邮件
    
    // $mail->AddAttachment('./tangqi.txt','tangqi.txt'); // 添加附件,并指定名称 

    //发送邮件信息
    $mail -> Addaddress($email); // 收件人
    $mail->FromName = 'tangqi';//发送人姓名
    $mail -> Subject = '邮箱验证';   // 标题
    $mail -> Body = $_SESSION['ecode'];    // 内容        
    if($mail->send()){
        return 1;
    }else{
        // echo $mail->ErrorInfo; 
        return 2; 
    }
}
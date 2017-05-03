<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>用户登陆</title>

    <link rel="stylesheet" href="/Public/Semantic/semantic.min.css">
    <script src="/Public/jquery/jquery.min.js"></script>
    <script src="/Public/Semantic/semantic.min.js"></script>
    <style>
        body{margin: 1rem;}
    </style>
</head>
<body>
<div class="ui grid">

    <div class="row" style="background: #0d71bb;color: #F8FFFF;font-size:20px;text-align:center">
        <div class="sixteen wide column">
            <h1>找回密码</h1>
        </div>
    </div>

    <form class="ui form" style="margin:0px auto" action="<?php echo U('Login/index',['opt'=>'doemail']);?>" method="post" class="ui segment form"><br/>

        <div>
            <input type="text" name="name" class="username" placeholder="用户名" autocomplete="off"/>
        </div><br/>
            <div >
            <input type="email" name="email" placeholder="邮箱">
        </div>
        <div>
            <input type="text" name="ecode" placeholder="验证码" style="width:230px;    margin-top:10px">
            <a id="sendmail" style="margin-top:9px;width:75px;">发送</a>
        </div>
        <br/>
        <button type="submit" id="save" >下一步</button>
    </form>
    <div class="">
        <span class="help-block u-errormessage" id="js-server-helpinfo">&nbsp;</span>
        <a href="#"></a>
    </div>

</div>

<script>

    $('#sendmail').click(function(){
        var email= $('[name=email]').val();
        $.post('/Email/send.php',{email:email},function(res){
            if(res==1){
                alert('发送成功');
            }else{
                alert('发送失败');
            }
        })
    })
    $('#save').click(function(){
        var ecode=$('[name=ecode]').val();
        $.post("<?php echo U('index.php',['opt'=>'doemail']);?>",{ecode:ecode},function(res){
            if(res==1){
                alert('邮箱验证码正确');
            }else{
                alert('邮箱验证码错误');
            }
        })
    })
</script>
</body>
</html>
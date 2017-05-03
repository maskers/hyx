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
            欢迎登录学生档案管理后台
        </div>
    </div>

    <form class="ui form" style="margin:0px auto" action="<?php echo U('Login/index',['opt'=>'doLogin']);?>" method="post" class="ui segment form"><br/>
        <div class="field">
            <label>邮箱：</label>
            <input type="text" name="name" placeholder="请输入邮箱">
        </div>
        <div class="field">
            <label>密码：</label>
            <input type="password" name="pwd" placeholder="请输入密码">
        </div>
        <button class="ui button" type="submit">登&nbsp;&nbsp;录</button>
        <a href="">忘记密码？</a>
    </form>

</div>
</body>
</html>
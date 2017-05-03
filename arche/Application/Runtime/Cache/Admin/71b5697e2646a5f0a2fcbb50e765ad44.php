<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title>学生档案管理 -</title>

<link rel="stylesheet" href="/Public/jiaoben3721/css/style.css">
<script src="/Public/jquery/jquery.min.js"></script>
<script src="/Public/Semantic/semantic.min.js"></script>
<style>
    body{margin: 1rem;}
</style>
<body>
<div class="ui grid">
<div class="login-container">
    <h1>重置密码</h1>

    <div class="connect">

    </div style="background: #0d71bb;color: #F8FFFF;font-size:20px;text-align:center">
    <form action="<?php echo U('Login/index',['opt'=>'doreset']);?>" method="post"  id="registerForm">
        <input type="hidden" name="id"    value="<?php echo ($id); ?>">
        <div>
            <input type="password" name="password" class="password" placeholder="输入密码" oncontextmenu="return false" onpaste="return false" />
        </div>
        <div>
            <input type="password" name="confirm_password" class="confirm_password" placeholder="再次输入密码" oncontextmenu="return false" onpaste="return false" />
        </div>
        <button id="submit" type="submit">重置密码</button>
    </form>
</div>

</div>
</body>
</html>
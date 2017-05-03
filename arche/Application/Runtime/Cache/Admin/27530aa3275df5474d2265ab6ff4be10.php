<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title></title>
	<link rel="stylesheet" href="/Public/semantic/semantic.min.css">
	<script src="/Public/jquery/jquery.min.js"></script>
	<script src="/Public/semantic/semantic.min.js"></script>
  <script src="/Public/plugin/cityselect/jquery.cityselect.js"></script>
	<style>
		body{padding:1rem; font-family: '微软雅黑'; background-color: #FFFAFA}
    .top_right{float:right;}
	</style>
</head>
<body>
<div class="ui grid">

<div class="row" style="background:#0d71bb; color:#fff;">
	<div class="sixteen wide column" style="font-size:18px; padding-left:20px;text-align:center">
		  欢迎进入学生档案管理后台&nbsp;&nbsp;&nbsp;&nbsp;
            <a style="color:#090909;font-size:14px;font-weight:bold;">当前用户：
				<img src="/Uploads/<?php echo session('loginInfo.photo');?>"/>
				<?php echo session('loginUser');?>[<?php echo session('loginInfo.gname');?>]</a>
            <a href="<?php echo U('login/index',['opt'=>'loginout']);?>" style="color:#090909;font-size:14px">退出</a>
	</div>
</div>
<div class="row">
	<div class="three wide column">

      <div class="ui vertical pointing menu">
        <?php if(is_array($navMenus)): $i = 0; $__LIST__ = $navMenus;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><a class="item"  href="<?php echo U($vo['url']);?>"><?php echo str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;',$vo['level']);?>
          <i class="<?php echo ($vo["icon"]); ?> icon"></i><?php echo ($vo["name"]); ?></a><?php endforeach; endif; else: echo "" ;endif; ?>
      </div>


	</div>
	<div class="thirteen wide column">
		

<!-- 添加 -->
<!-- <button class="ui button" id="addstudent"><i class="add icon"></i>添加老师</button> -->
<form id="add_fm" class="ui segment form" action="<?php echo U('index',['opt'=>'doAddStudent'],'');?>" method="post" enctype='multipart/form-data'>
    <h4 class="ui dividing header">添加学生</h4>
	<div class="ui form">
	  <div class="fields">
	    <div class="four wide field">
	      <label>姓名</label>
	      <input type="text" name='sname' placeholder="name">
	    </div>
	    <div class="four wide field">
	      <label>手机</label>
	      <input type="text" name='tel' placeholder="tel">
	    </div>
	    <div class="four wide field">
	      <label>邮箱</label>
	      <input type="text" name='email' placeholder="email">
	    </div>
	    <div class="four wide field">
	      <label>性别</label>
	      <select class="ui dropdown" name="sex">
            <?php if(is_array($sexs)): $i = 0; $__LIST__ = $sexs;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["value"]); ?>" ><?php echo ($vo["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
          </select>
	    </div>
	  </div>

	  <div class="fields">
        <div class="four wide field">
            <label>密码</label>
            <input type="password" name="pwd">
        </div>
        <div class="four wide field">
            <label>确认密码</label>
            <input type="password" name="pwd2">
        </div>
        <div class="four wide field">
            <label>班级</label>
            <select class="ui dropdown" name="class">
                <?php if(is_array($class)): $i = 0; $__LIST__ = $class;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["value"]); ?>"><?php echo ($vo["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
            </select>
        </div>
        <div class="four wide field">
            <label>学期</label>
            <select class="ui dropdown" name="term">
                <?php if(is_array($term)): $i = 0; $__LIST__ = $term;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["value"]); ?>"><?php echo ($vo["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
            </select>
        </div>
      </div>

      <div class="fields">
	    <div class="four wide field">
            <label>身份证</label>
            <input type="text" name="id_card">
        </div>
        <div class="four wide field">
            <label>年龄</label>
            <input type="text" name="age">
        </div>
        <div class="four wide field">
            <label>qq</label>
            <input type="text" name="qq">
        </div>
        <div class="four wide field">

        </div>
        
	  </div>

      <div class="fields">
          <div class="four wide field">
              <label>头像</label>
              <input type="file" name="file" value="">
          </div>
      </div>
      <div class="fields">
        <label style="font-size:16px;font-weight:bold;">家庭住址：</label>
      </div>
      <div class="fields" id="city">
         <div class="three wide field">
              <label>省</label>
              <select class="prov" name="prov" ></select>  
         </div>
         <div class="three wide field">
              <label>市</label>
              <select class="city" name="city" disabled="disabled"></select> 
         </div>
         <div class="three wide field">
              <label>县</label>
              <select class="dist" name="dist" disabled="disabled"></select> 
         </div>
      </div>
      <div class="fields">
        <div class="eight wide field">
            <label>详细地址</label>
            <input type="text" name="addr">
        </div>
      </div>

      <div class="fields">
        <div class="four wide field">
            <label>毕业院校</label>
            <input type="text" name="school">
        </div>
        <div class="four wide field">
            <label>专业</label>
            <input type="text" name="major">
        </div>
        <div class="four wide field">
            <label>毕业时间</label>
            <input type="date" name="gra_time">
        </div>
        <div class="four wide field">
            <label>学历</label>
            <select class="ui dropdown" name="education">
                <?php if(is_array($education)): $i = 0; $__LIST__ = $education;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["value"]); ?>"><?php echo ($vo["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
            </select>
        </div>
      </div>
        <button class="ui tiny primary button"><i class="add icon"></i>添加</button>
	</div>
</form>


<script>
$('.dropdown').dropdown();

//地市联动
$('#city').citySelect({
    url:'/Public/plugin/cityselect/city.min.js',
    nodata:"none",//隐藏无数据的子级select
    required:true,
     prov:"江苏",
     city:"南京",
     dist:"白下区",
});



//验证添加表单
$.fn.form.existFlag = false;
$.fn.form.settings.rules.exist = function(value,param) {
    $.ajax({
        url:'<?php echo U("index",["opt"=>"same"]);?>',
        data:{field:param,value:value},
        async:true,
        success:function (data) {
            $.fn.form.existFlag = data;
        }
    });
    return !$.fn.form.existFlag;
};

$('#add_fm').form({
    on: 'blur',
    inline: true,
    fields:{
    sname: {
        identifier: 'sname',
        rules: [
            {
                type: 'empty',
                prompt: '{name}不能为空！'
            },
            {
                type: 'regExp',
                value: '/^[^\u0000-\u00FF]{2,6}$/',
                prompt : '{name}必须2-6位汉字！'
            },
            {
                type: 'exist[name]',
                prompt : '{name}已经存在！'
            },
        ]
    },

    tel: {
        identifier: 'tel',
        rules: [
            {
                type: 'empty',
                prompt: '{name}不能为空！'
            },
            {
                type: 'regExp',
                value: '/^1[3|4|5|8][0-9]\\d{8,8}$/',
                prompt : '{name}号非法！'
            },
            {
                type: 'exist',
                value:'tel',
                prompt : '{name}已经存在！'
            },
        ]
    },

    age: {
        identifier: 'age',
        rules: [
            {
                type: 'regExp',
                value: '/^(1[89]|[2-8][0-9]|90)$/',
                prompt : '{name}号非法！'
            },
        ]
    },

    email: {
        identifier: 'email',
        rules: [
            {
                type: 'empty',
                prompt: '{name}不能为空！'
            },
            {
                type: 'email',
                prompt : '{name}非法！'
            },
            {
                type: 'exist[email]',
                prompt : '{name}已经存在！'
            },
        ]
    },

    pwd: {
        identifier: 'pwd',
        rules: [
            {
                type: 'empty',
                prompt: '{name}不能为空！'
            },
            {
                type: 'regExp',
                value: '/^[A-Za-z0-9]{6,20}$/',
                prompt : '{name}只能6-20位字母数字组合 ！'
            },
        ]
    },

    match: {
        identifier  : 'pwd2',
        rules: [
          {
            type   : 'match[pwd]',
            prompt : '两次密码输入不一致'
          }
        ]
    },
  }
});



</script>

	</div>
</div>



</div>
</body>


<script>
	$('.accordion')
  .accordion({
    selector: {
      trigger: '.title .icon'
    }
  })
;


  
</script>




</html>
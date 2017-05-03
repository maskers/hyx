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
<button class="ui button" id="addteacher"><i class="add icon"></i>添加老师</button>
<form id="add_fm" class="ui segment form" action="<?php echo U('index',['opt'=>'doAddTeacher'],'');?>" method="post" enctype='multipart/form-data'>
    <h4 class="ui dividing header">添加老师</h4>
	<div class="ui form">
	  <div class="fields">
	    <div class="four wide field">
	      <label>姓名</label>
	      <input type="text" name='name' placeholder="name">
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
            <?php if(is_array($sexs)): $i = 0; $__LIST__ = $sexs;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["value"]); ?>"><?php echo ($vo["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
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
            <label>角色</label>
            <select class="ui dropdown" name="group">
                <?php if(is_array($group)): $i = 0; $__LIST__ = $group;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
            </select>
        </div>
	  </div>
      <div class="fields">
          <div class="four wide field">
              <label>头像</label>
              <input type="file" name="file" value="">
          </div>
      </div>
        <button class="ui tiny primary button"><i class="add icon"></i>添加</button>
	</div>
</form>







<!-- 编辑 -->
<div class="ui modal edit">
<form id="edit_fm" class="ui segment form" action="<?php echo U('index',['opt'=>'doEdit'],'');?>" method="post" enctype='multipart/form-data'>
<input type="hidden" name='id' value="">
    <h4 class="ui dividing header">编辑老师</h4>
	<div class="ui form">
	  <div class="fields">
	    <div class="four wide field">
	      <label>姓名</label>
	      <input type="text" disabled name='name' placeholder="name">
	    </div>
	    <div class="four wide field">
	      <label>手机</label>
	      <input type="text" name='tel' placeholder="icon">
	    </div>
	    <div class="four wide field">
	      <label>邮箱</label>
	      <input type="text" name='email' placeholder="URL">
	    </div>
	    <div class="four wide field">
	      <label>性别</label>
	      <select class="ui dropdown" name="sex">
            <?php if(is_array($sexs)): $i = 0; $__LIST__ = $sexs;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["value"]); ?>"><?php echo ($vo["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
          </select>
	    </div>
	  </div>
	  <div class="fields">
        <div class="four wide field">
            <label>班级</label>
            <select class="ui dropdown" name="class">
                <?php if(is_array($class)): $i = 0; $__LIST__ = $class;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["value"]); ?>"><?php echo ($vo["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
            </select>
        </div>
        <div class="four wide field">
            <label>角色</label>
            <select class="ui dropdown" name="group">
                <?php if(is_array($group)): $i = 0; $__LIST__ = $group;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>" {$vo[id]==2?"selected":""} ><?php echo ($vo["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
            </select>
        </div>
        <div class="four wide field">
          <label>头像</label>
          <input type="file" name="file" value="">
        </div>
	  </div>
        <button class="ui tiny primary button"><i class="add icon"></i>保存</button>
	</div>
</form>
</div>









<!-- 显示 -->
<table class="ui celled table">
  <thead>
    <tr>
   		<th>
            <input class="ui checkbox" type="checkbox" name="example" id="select">
        </th>
	    <th>姓名</th>
	    <th>角色</th>
	    <th>电话</th>
	    <th>邮箱</th>
	    <th>头像</th>
	    <th>性别</th>
	    <th>班级</th>
	    <th>状态</th>
	    <th>添加日期</th>
	    <th>操作</th>
  </tr></thead>
  <tbody>
  	<?php if(is_array($teachers)): $i = 0; $__LIST__ = $teachers;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr id="del_<?php echo ($vo["id"]); ?>" >
	      <td>
            <div class="ui checkbox">
                <input type="checkbox" name="example" >
                <label></label>
            </div>
          </td>
	      <td><?php echo ($vo["name"]); ?></td>
	      <td><?php echo ($vo["group"]); ?></td>
	      <td><?php echo ($vo["tel"]); ?></td>
	      <td><?php echo ($vo["email"]); ?></td>
	      <td><img class="img" src="/Uploads/<?php echo ($vo["mphoto"]); ?>" name="<?php echo ($vo["mphoto"]); ?>" id="<?php echo ($vo["photo"]); ?>"/></td>
	      <td><?php echo ($vo["sex"]); ?></td>
	      <td><?php echo ($vo["class"]); ?></td>
	      <td><?php echo ($vo["status"]); ?></td>
	      <td><?php echo ($vo["ctime"]); ?></td>
	      <td>
	      	<div class="mini ui buttons">
			  <a href="<?php echo U('index',['opt'=>'edit','id'=>$vo['id']],'');?>" class="mini ui positive button editTea">编辑</a>
			  <div class="or"></div>
			  <button  onclick="{if(confirm('确定要删除吗?')){del('<?php echo ($vo["id"]); ?>'); }else{}}" class="mini ui negative button" id="delmenu">删除</button>
			</div>
	      </td>
	    </tr><?php endforeach; endif; else: echo "" ;endif; ?>
  </tbody>
  <tfoot>
  	<tr>
        <th colspan="11">
            <div id="pages">
                <?php echo ($pages); ?>
            </div>
        </th>
    </tr>
  </tfoot>
</table>

<div class="blue ui buttons">
    <div class="ui button" id='selectAll'>全选</div>
    <div class="ui button" id='selectNone'>全不选</div>
    <div class="ui button" id='nuSelect'>反选</div>

</div>



<div class="ui modal" id="showImg">
    <img src=""  />
</div>



<script>
$('.img').click(function(){
    var src = '/Uploads/'+this.id;
    $('#showImg img').prop('src',src);
    $('#showImg').modal('show');

})


//删除老师
function del(id){
	var tr_id = '#del_'+id;
	// console.log(tr_id);
	

	var url = "<?php echo U('index',['opt'=>'delTeacher'],'');?>/id/"+id;
	$.get(url,'',function(res){
		console.log(res);
		if(res==1){
            $(tr_id).empty();
            
			alert('删除成功');
		}else{
			alert('删除失败');
		}
	})
}



//添加菜单动画下拉
$('#add_fm').hide();
$('#addteacher').click(function(){
	$('#add_fm').slideToggle();
});


//显示编辑
$('.editTea').click(function(){

    $('.edit').modal('show');

    $.get($(this).prop('href'),{},function(res){
        $('#edit_fm').form('set values',res);
    })

    return false;
});




$('select').dropdown();

//修饰分页样式
$('#pages>div').addClass('ui right floated pagination menu');
$('#pages>div a ,#pages>div .current').addClass('icon item');
$('#pages>div .current').css({'font-weight': 'bold','color': '#0d71bb'});


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

$('#add_fm,#edit_fm').form({
    on: 'blur',
    inline: true,
    fields:{
    name: {
        identifier: 'name',
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






//全选
$('#selectAll').click(function(){
    $('table td [type=checkbox]').prop('checked',true);
});
//全不选
$('#selectNone').click(function(){
    $('table td [type=checkbox]').prop('checked',false);
});
$('#select').click(function(){
    var status = $(this).prop('checked');
    $('table td [type=checkbox]').prop('checked',status);
});
$('#nuSelect').click(function(){
    $('table td [type=checkbox]').prop('checked',function(index,value){
        return !$(this).prop('checked');
    });
});

//删除选中的
$('#delSelect').click(function(){
    // console.log('hello');
    var i=0;
    var p = 0;
    $.each($('#tbd [type=checkbox]:checked'),function(k,v){
console.log(v);
        i=i+1;
        var tr = '#'+'del_'+v.name;
        // console.log(tr);
        $(tr).empty();

        var url="<?php echo U('index',['opt'=>'delDict'],'');?>/id/"+v.name;
        $.get(url,'',function(res){
            console.log(res);
            if(res==1){
                p+=1;
            }else{
                //alert('删除失败');
            }
            if(i==p){
                alert('删除成功');
            }
        });
    })
})




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
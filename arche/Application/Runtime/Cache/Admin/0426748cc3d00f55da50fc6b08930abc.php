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
<button class="ui button" id="addmenu"><i class="add icon"></i>添加群组</button>
<form id="add_fm" class="ui segment form" action="<?php echo U('index',['opt'=>'doAddGroup'],'');?>" method="post">
    <!-- <h4 class="ui dividing header">添加群组</h4> -->
	<div class="ui form">
	  <div class="fields">
	    <div class="four wide field">
	      <label>群组名称</label>
	      <input type="text" name='name' placeholder="name">
	    </div>
	    
	    <div class="twelve wide field">
	      <label>规则</label>
	      	<div class="ui fluid multiple search normal selection dropdown" >
			    <input type="hidden" name="rule" >
			    <i class="dropdown icon"></i>
			    <div class="default text">请选择规则</div>
			    <div class="menu">
					

				    <?php if(is_array($navMenus)): $i = 0; $__LIST__ = $navMenus;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="item" data-value="<?php echo ($vo["id"]); ?>">
	                    <?php echo str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;',$vo['level']);?>
	                    <i class="<?php echo ($vo["icon"]); ?> icon"></i>
	                    <?php echo ($vo["name"]); ?>
	                	</div><?php endforeach; endif; else: echo "" ;endif; ?>

			  	</div>
			</div>
	 	 </div>
	  </div>
        <button class="ui tiny primary button"><i class="add icon"></i>保存</button>
	</div>
</form>

<div style="height:20px;"></div>






<form action="<?php echo U('index',['opt'=>'doEditGroup'],'');?>" method="post">
<input type="hidden" name='id' value="<?php echo ($vo["id"]); ?>">
<table class="ui celled table">
  <thead>
    <tr>
	    <th><input type="checkbox" class="ui checkbox" id="select"></th>
	    <th>群组名称</th>
	    <th>权限</th>
	    <th>操作</th>
  </tr></thead>
  <tbody id="tbd">
  	<?php if(is_array($groups)): $i = 0; $__LIST__ = $groups;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr id="tr_<?php echo ($vo["id"]); ?>">
	      <td><input type="checkbox" class="ui checkbox"></td>
	      <td>
				<div class="ui input focus" id="td_<?php echo ($vo["id"]); ?>"><?php echo ($vo["name"]); ?></div>
	      <td width="600px">

	      	<div class="ui fluid multiple search normal selection dropdown menuGroup" >
			    <input type="hidden" name="rule"  value="<?php echo ($vo["rule"]); ?>">
			    <i class="dropdown icon"></i>
			    <div class="default text">规则</div>
			    <div class="menu">
					
				    <?php if(is_array($navMenus)): $i = 0; $__LIST__ = $navMenus;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><div class="item" data-value="<?php echo ($v["id"]); ?>">
	                    <?php echo str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;',$v['level']);?>
	                    <i class="<?php echo ($v["icon"]); ?> icon"></i>
	                    <?php echo ($v["name"]); ?>
	                	</div><?php endforeach; endif; else: echo "" ;endif; ?>

			  	</div>
			</div>


	      </td>
	      <td>
	      	<div class="mini ui buttons" id="edit_<?php echo ($vo["id"]); ?>">
			  <a class="mini ui positive button edit" id="<?php echo ($vo["id"]); ?>" href ="<?php echo ($vo["name"]); ?>">编辑</a>
			  </form>
			  <div class="or"></div>
			  <a  onclick="{if(confirm('确定要删除吗?')){del('<?php echo ($vo["id"]); ?>'); }else{}}" class="mini ui negative button" >删除</a>
			</div>
	      </td>
	    </tr><?php endforeach; endif; else: echo "" ;endif; ?>
  </tbody>
  <tfoot></tfoot>
</table>


	<div class="blue ui buttons">
		<div class="ui button" id='selectAll'>全选</div>
		<div class="ui button" id='selectNone'>全不选</div>
		<div class="ui button" id='nuSelect'>反选</div>

	</div>
<!-- 分页 -->
<div class="small ui buttons" style="float:right; margin-right:50px;">
	<a href="<?php echo U('index',['opt'=>'showGroup'],'');?>/p/<?php echo ($p-1); ?>"><div class="ui button"><<</div></a>
	<?php $__FOR_START_29440__=1;$__FOR_END_29440__=$pages+1;for($i=$__FOR_START_29440__;$i < $__FOR_END_29440__;$i+=1){ ?><a href="<?php echo U('index',['opt'=>'showGroup'],'');?>/p/<?php echo ($i); ?>"><div class="ui button"><?php echo ($i); ?></div></a><?php } ?>
	<a href="<?php echo U('index',['opt'=>'showGroup'],'');?>/p/<?php echo ($p+1); ?>"><div class="ui button">>></div></a>
</div>



<script>
//编辑群组
$('.edit').click(function(){
    var id = this.id;
    //console.log(id);
    var td = "#tr_"+id+" td";
    //console.log($(/td));
    var div = td+":eq(1) div";
    //console.log($(div).text());
    var html = '<div  class="ui input focus"><input type="hidden" name="id" value="'+id+'"><input type="text" class="ui checkbox" name="name" value="'+$(div).text()+'"><div>';
    $(td).eq(1).html(html);
    console.log($(td).eq(1));
    console.log(html);
    var edit_a = '#edit_'+id;
    var edit_a = '#'+id;
    $(edit_a).replaceWith("<button class='mini ui button' id='"+id+"'>保存</button>");
    return false;
})



//删除选中的
$('#delSelect').click(function(){
	// console.log('hello');
	var i=0;
	var p = 0;
	$.each($('#tbd [type=checkbox]:checked'),function(k,v){
console.log(v);
		i=i+1;
		var tr = '#'+'tr_'+v.name;
		// console.log(tr);
		$(tr).empty();

		var url="<?php echo U('index',['opt'=>'delGroup'],'');?>/id/"+v.name;
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



// 下拉菜单
$('.menuGroup,.dropdown').dropdown({
	useLabels:true,
	maxSelections:3});

//下拉菜单
// $('.dropdown').dropdown();




//删除群组
function del(id){
	var tr_id = '#tr_'+id;
	console.log(tr_id);
	$(tr_id).empty();

	var url = "<?php echo U('index',['opt'=>'delGroup'],'');?>/id/"+id;
	$.get(url,'',function(res){
		console.log(res);
		if(res==1){
			alert('删除成功');
		}else{
			alert('删除失败');
		}
	})
}







//添加菜单动画下拉
$('#add_fm').hide();
$('#addmenu').click(function(){
	$('#add_fm').slideToggle();
});



//添加菜单验证
$('#add_fm')
  .form({
    on: 'blur',
    inline: true,
    fields: {
      name: {
        identifier  : 'name',
        rules: [
          {
            type   : 'empty',
            prompt : '{name}不能为空'
          }
        ]
      },
      rule: {
        identifier  : 'rule',
        rules: [
          {
            type   : 'empty',
            prompt : '{name}不能为空'
          }
        ]
      },
    
    }
  })
;





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
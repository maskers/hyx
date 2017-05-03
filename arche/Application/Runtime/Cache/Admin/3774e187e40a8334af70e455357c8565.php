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
		

<button class="ui button" id="addmenu"><i class="add icon"></i>添加菜单</button>
<form id="add_fm" class="ui segment form" action="<?php echo U('index',['opt'=>'doAddMenu'],'');?>" method="post">
    <h4 class="ui dividing header">添加菜单</h4>
	<div class="ui form">
	  <div class="fields">
	    <div class="four wide field">
	      <label>名称</label>
	      <input type="text" name='name' placeholder="name">
	    </div>
	    <div class="four wide field">
	      <label>图标</label>
	      <input type="text" name='icon' placeholder="icon">
	    </div>
	    <div class="four wide field">
	      <label>URL</label>
	      <input type="text" name='url' placeholder="URL">
	    </div>
	    <div class="four wide field">
	      <label>排序</label>
	      <input type="text" name='sort' placeholder="sort">
	    </div>
	  </div>
	  <div class="fields">
	    <div class="field">
	      <label>上级目录</label>
	      	<div class="ui selection dropdown pid" >
			    <input type="hidden" name="pid">
			    <i class="dropdown icon"></i>
			    <div class="default text">上级目录</div>
			    <div class="menu">
					

					<div class="item" data-value="0">顶级菜单</div>
				    <?php if(is_array($menus)): $i = 0; $__LIST__ = $menus;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="item" data-value="<?php echo ($vo["id"]); ?>">
	                    <?php echo str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;',$vo['level']);?>
	                    <i class="<?php echo ($vo["icon"]); ?> icon"></i>
	                    <?php echo ($vo["name"]); ?>
	                </div><?php endforeach; endif; else: echo "" ;endif; ?>

			  </div>
			</div>
	    </div>
	    <div class="field">
	      <label>状态</label>
	      <select name="status" class="pid">
	      	<?php if(is_array($status)): $i = 0; $__LIST__ = $status;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
	      </select>
	    </div>
	  </div>
        <button class="ui tiny primary button"><i class="add icon"></i>保存</button>
	</div>
</form>

<table class="ui celled table">
  <thead>
    <tr>
	    <th><div class="ui ribbon label">名称</div></th>
	    <th>URL</th>
		<th>图标</th>
	    <th>排序</th>
	    <th>状态</th>
	    <th>操作</th>
  </tr></thead>
  <tbody>
  	<?php if(is_array($menus)): $i = 0; $__LIST__ = $menus;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr id="del_<?php echo ($vo["id"]); ?>" >
	      <td style="font-size:14px;"><?php echo str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;',$vo['level']);?><i class="<?php echo ($vo["icon"]); ?>  icon"></i><?php echo ($vo["name"]); ?></td>

	      <td><?php echo ($vo["url"]); ?></td>
			<td><i class="<?php echo ($vo["icon"]); ?> icon"></i></td>
	      <td><?php echo ($vo["sort"]); ?></td>
	      <td><?php echo ($vo["status"]); ?></td>
	      <td>
	      	<div class="mini ui buttons">
			  <a class="mini ui positive button" id='<?php echo ($vo["id"]); ?>' onclick="edit('<?php echo ($vo["id"]); ?>,'+'<?php echo ($vo["name"]); ?>,'+'<?php echo ($vo["url"]); ?>,'+'<?php echo ($vo["status"]); ?>,'+'<?php echo ($vo["pid"]); ?>,'+'<?php echo ($vo["sort"]); ?>,'+'<?php echo ($vo["icon"]); ?>')" >编辑</a>
			  <div class="or"></div>
			  <button  onclick="{if(confirm('确定要删除吗?')){del('<?php echo ($vo["id"]); ?>'); }else{}}" class="mini ui negative button" id="delmenu">删除</button>
			</div>

	      </td>
	    </tr><?php endforeach; endif; else: echo "" ;endif; ?>
  </tbody>
  <tfoot></tfoot>
</table>


<div class="ui modal" id="edit_menu">

</div>


<script>

//弹出框
function edit(str){
	// console.log(str);
	var arr = str.split(',');
	// console.log(arr);
	var url = "<?php echo U('index',['opt'=>'editMenu'],'');?>/id/"+arr[0];
	$.get(url,'',function(res){
		// console.log(res);
		var a='';
		if(res==2){
			a = 'disabled';
		}
		var html=' <i class="close icon"></i><div class="header">编辑菜单</div><form class="ui segment form" action="<?php echo U('index',['opt'=>'doEditMenu'],'');?>" method="post"><input type="hidden" name="id" value="'+arr[0]+'"><div class="ui form"><div class="fields">	    <div class="four wide field">	      <label>名称</label>	      <input type="text" name="name" placeholder="name" value="'+arr[1]+'">   </div>	    <div class="four wide field">	      <label>图标</label>	      <input type="text" name=\'icon\' placeholder="icon" value="'+arr[6]+'">	    </div>	    <div class="four wide field">	      <label>URL</label>	      <input type="text" name="url" placeholder="URL" value="'+arr[2]+'">	    </div>	    <div class="four wide field">	      <label>排序</label>	      <input type="text" name="sort" placeholder="sort" value="'+arr[5]+'">	    </div>	  </div>	  <div class="fields">	    <div class="field">	    												  <label>上级目录</label> 	<div class="ui selection dropdown pid" >	  <input type="hidden" name="pid" value="'+arr[4]+'">			    <i class="dropdown icon"></i>			    <div class="default text">上级目录</div>			    <div class="menu">					<div class="'+a+' item" data-value="0">顶级菜单</div>				    <?php if(is_array($menus)): $i = 0; $__LIST__ = $menus;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="'+a+' item" data-value="<?php echo ($vo["id"]); ?>">	                    <?php echo str_repeat("&nbsp;&nbsp;&nbsp;&nbsp;",$vo["level"]);?>	                    <i class="<?php echo ($vo["icon"]); ?> icon"></i>	                    <?php echo ($vo["name"]); ?>	                </div><?php endforeach; endif; else: echo "" ;endif; ?>			  </div>			</div>   </div>	    <div class="field">	      <label>状态</label>	      <select name="status" class="pid">	      	<?php if(is_array($status)): $i = 0; $__LIST__ = $status;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>"  ><?php echo ($vo["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>	      </select>	    </div>	  </div>	</div>  <div class="actions">    <div class="ui black deny button" id="giveup">      放弃    </div>    <button class="ui positive right labeled icon button" id="save">     保存     <i class="checkmark icon"></i>    </button>  </div>  </form>	';
			// console.log(html);
			$('#edit_menu').html(html);


	$('.ui.modal').modal('show');


	//下拉菜单
	$('.pid').dropdown();



	$('#giveup').click('');
	//编辑菜单
	$('#save').click(function(){
		console.log('hello');
		// var arr = $('#add [type=text]');
	})



	})

}

//添加菜单
$('#add_fm').hide();
$('#addmenu').click(function(){
	$('#add_fm').slideToggle();
});

//菜单删除
function del(id){
	var tr_id = '#del_'+id;
	$(tr_id).empty();

	var url = "<?php echo U('index',['opt'=>'delMenu'],'');?>/id/"+id;
	$.get(url,'',function(res){
		// console.log(res);
		if(res==1){
			alert('删除成功');
		}else{
			alert('删除失败');
		}
	})
}


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
      icon: {
        identifier  : 'icon',
        rules: [
          {
            type   : 'empty',
            prompt : '{name}不能为空'
          }
        ]
      },
      url: {
        identifier  : 'url',
        rules: [
          {
            type   : 'empty',
            prompt : '{name}不能为空'
          }
        ]
      },
      sort: {
        identifier  : 'sort',
        rules: [
          {
            type   : 'empty',
            prompt : '{name}不能为空'
          }
        ]
      }
      
    }
  })
;


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
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
		

<form id="select_fm" class="ui segment form" action="" method="post">
    <h4 class="ui dividing header">筛选</h4>
	<div class="ui form">
	  <div class="fields">
	    <div class="four wide field">
		    <?php if(is_array($fields)): $i = 0; $__LIST__ = $fields;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><a> <input type="checkbox" class="ui checkbox" name='field[]' value="<?php echo ($vo["field"]); ?>" ><?php echo ($vo["field"]); ?>&nbsp;&nbsp;</a><?php endforeach; endif; else: echo "" ;endif; ?>
	    </div>
	    
	  </div>
	</div>
	<a style="text-align: center"><button class="ui tiny primary button"><i class="Sign out icon"></i>筛选</button></a>
</form>


<button class="ui button" id="add_btn"><i class="add icon"></i>添加字典</button>





<table class="ui celled table">
<form action="<?php echo U('index',['opt'=>'doEditDict'],'');?>" method="post">
  <thead>
    <tr>
	    <th><input type="checkbox" class="ui checkbox" id="select"></th>
	    <th>字段</th>
	    <th>名称</th>
	    <th>值</th>
	    <th>操作</th>
  </tr></thead>
  <tbody id="tbd">
  	<?php if(is_array($dicts)): $i = 0; $__LIST__ = $dicts;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr id="del_<?php echo ($vo["id"]); ?>" >
	      <td><input type="checkbox" class="ui checkbox"></td>
	      <td><?php echo ($vo["field"]); ?></td>
	      <td><?php echo ($vo["name"]); ?></td>
	      <td><?php echo ($vo["value"]); ?></td>
	      <td>
	      	<div class="mini ui buttons">
			  <a class="mini ui positive button" id='edit_<?php echo ($vo["id"]); ?>' onclick="edit('<?php echo ($vo["id"]); ?>')" >编辑</a>
			  <div class="or"></div></form>
			  <a onclick="{if(confirm('确定要删除吗?')){del('<?php echo ($vo["id"]); ?>'); }else{}}" class="mini ui negative button" id="deldict">删除</a>
			</div>
	      </td>
	    </tr><?php endforeach; endif; else: echo "" ;endif; ?>
  </tbody>


  <tfoot>
    <tr id="pages">
    	<th colspan="5">
			
		</th>
		<th colspan="5">
			<?php echo ($pages); ?>
		</th>
 	 </tr>
  </tfoot>
</table>

<div class="small blue ui buttons">
	<div class="ui button" id='selectAll'>全选</div>
	<div class="ui button" id='selectNone'>全不选</div>
	<div class="ui button" id='nuSelect'>反选</div>

</div>




<div class="ui modal" id="add_dict">

</div>


<script>
//删除字典
function del(id){
	var tr_id = '#del_'+id;
	// console.log(tr_id);
	$(tr_id).empty();

	var url = "<?php echo U('index',['opt'=>'delDict'],'');?>/id/"+id;
	$.get(url,'',function(res){
		console.log(res);
		if(res==1){
			alert('删除成功');
		}else{
			alert('删除失败');
		}
	})
}



//编辑
function edit(id){
	var tr = '#del_'+id;
	var td = tr+' td';
	// console.log($(td).eq(1).text());
	var html = '<input type="hidden" name="id" value="'+id+'"><td><input type="checkbox" class="ui checkbox"></td>	      <td><div  class="ui input focus"><input name="field"  type="text" value="'+$(td).eq(1).text()+'"/></div></td>	      <td><div  class="ui input focus"><input name="name" type="text" value="'+$(td).eq(2).text()+'"/><div></td>	      <td><div  class="ui input focus"><input name="value" type="text" value="'+$(td).eq(3).text()+'"/></div></td>	      <td>	      	<div class="mini ui buttons">			  <button class="mini ui button" >保存</button>			  <div class="or"></div>			  <a  onclick="{if(confirm(\'确定要删除吗?\')){del("'+id+'""); }else{}}" class="mini ui negative button" id="deldict">删除</a>			</div>	      </td>';
	console.log(html);
	$(tr).html(html);
}




//分页样式
	$('#pages div').addClass('ui right floated pagination menu');
	$('#pages a,#pages .current').addClass('item');
	$('#pages .current').css({'background':'#b0b3ad','color':'white'});




//弹出框 添加字典
$('#add_btn').click(function(){
	var html='<form id="adddict" class="ui segment form" action="<?php echo U('index',['opt'=>'doAddDict'],'');?>" method="post">    <h4 class="ui dividing header">添加字典</h4>	<div class="ui form">	  <div class="fields">	    <div class="four wide field">	      <label>字段</label>	      <input type="text" name=\'field\' placeholder="field">	    </div>	    <div class="four wide field">	      <label>名称</label>	      <input type="text" name="name" placeholder="name">	    </div>	    <div class="four wide field">	      <label>值</label>	      <input type="text" name=\'value\' placeholder="value">	    </div>	  </div>	</div>	 <div class="actions">    <div class="ui black deny button" id="giveup">      放弃    </div>    <button class="ui positive right labeled icon button" id="save">     保存     <i class="checkmark icon"></i>    </button>  </div>  </form>';
			console.log(html);
	$('#add_dict').html(html);
	$('.ui.modal').modal('show');

	//添加字典验证
	$('#adddict')
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
	      field: {
	        identifier  : 'field',
	        rules: [
	          {
	            type   : 'empty',
	            prompt : '{name}不能为空'
	          }
	        ]
	      },
	      value: {
	        identifier  : 'value',
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


})



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
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
		
    <style>
        td a:hover{ color:orange; }
    </style>

    <!-- 添加 -->
    <a href="<?php echo U('index',['opt'=>'addStudent']);?>"><button class="ui button" id="addstudent"><i class="add icon"></i>添加学生</button></a>


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
            <th>当前班级</th>
            <th>当前学期</th>
            <th>状态</th>
            <th>添加日期</th>
            <th>操作</th>
        </tr></thead>
        <tbody id="tbd">
        <?php if(is_array($students)): $i = 0; $__LIST__ = $students;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr id="del_<?php echo ($vo["sid"]); ?>" >
                <td>
                    <div class="ui checkbox">
                        <input type="checkbox" name="example" >
                        <label></label>
                    </div>
                </td>
                <td><?php echo ($vo["sname"]); ?></td>
                <td><?php echo ($vo["group"]); ?></td>
                <td><?php echo ($vo["tel"]); ?></td>
                <td><?php echo ($vo["email"]); ?></td>
                <td><img class="img" src="/Uploads/<?php echo ($vo["mphoto"]); ?>" name="<?php echo ($vo["mphoto"]); ?>" id="<?php echo ($vo["photo"]); ?>"/></td>
                <td><?php echo ($vo["sex"]); ?></td>
                <td><?php echo ($vo["class"]); ?></td>
                <td><?php echo ($vo["term"]); ?></td>
                <td><?php echo ($vo["status"]); ?></td>
                <td><?php echo ($vo["ctime"]); ?></td>
                <td>

                    <a  href="<?php echo U('index',['opt'=>'edit','id'=>$vo['sid']],'');?>" class="mini green ui button">编辑</a>
                    <a onclick="{if(confirm('确定要删除吗?')){del('<?php echo ($vo["sid"]); ?>'); }else{}}" id="delmenu" class="mini red ui button">删除</a>
                    <a  href="<?php echo U('index',['opt'=>'deduction','id'=>$vo['sid']],'');?>" class="mini ui button">扣分</a>
                    <a  href="<?php echo U('index',['opt'=>'exam','sid'=>$vo['sid']],'');?>" class="mini ui button">考试</a>
                    <a  href="<?php echo U('index',['opt'=>'detail','sid'=>$vo['sid']],'');?>" class="mini ui button">详情</a>


                </td>
            </tr><?php endforeach; endif; else: echo "" ;endif; ?>
        </tbody>
        <tfoot>
        <tr>
            <th colspan="12">
                <div id="pages">
                    <p><?php echo ($pages); ?></p>
                </div>
            </th>
        </tr>
        </tfoot>
    </table>

    <div class="small blue ui buttons">
        <div class="ui button" id='selectAll'>全选</div>
        <div class="ui button" id='selectNone'>全不选</div>
        <div class="ui button" id='nuSelect'>反选</div>

    </div>



    <div class="ui modal" id="showImg" style="text-align: center">
        <img src=""  />
    </div>



    <script>
        //修饰分页样式
        $('#pages>div').addClass('ui right floated pagination menu');
        $('#pages>div a ,#pages>div .current').addClass('icon item');
        $('#pages>div .current').css({'font-weight': 'bold','color': '#0d71bb'});



        $('.img').click(function(){
            var src = '/Uploads/'+this.id;
            $('#showImg img').prop('src',src);
            $('#showImg').modal('show');

        })


        //删除学生
        function del(id){
            var tr_id = '#del_'+id;



           var url = "<?php echo U('index',['opt'=>'delStudent'],'');?>/id/"+id;

          $.get(url,'',function(res){
                if(res==1){
                    alert('删除成功');
                    $(tr_id).empty();
                }else{
                    alert('删除失败');
                }
           });

        }



        $('select').dropdown();







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

                var url="<?php echo U('index',['opt'=>'delStudent'],'');?>/id/"+v.name;
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
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
		
<!-- <?php echo print_r($stu);?>
<?php echo print_r($deductions);?> -->
<h3 class="ui dividing header">当前学生【<?php echo ($stu["sname"]); ?>】</h3>
<form id="add_fm" class="ui segment form" method="post" action="<?php echo U('index',['opt'=>'addExam'],'');?>">
        <h3 class="ui dividing header">添加考试成绩</h3>
        <input name="sid" type="hidden" value="<?php echo ($stu["sid"]); ?>">
        <input name="class" type="hidden" value="<?php echo ($stu["class"]); ?>">
        <input name="term" type="hidden" value="<?php echo ($stu["term"]); ?>">
        <div class="fields">
            <div class="four wide field">
                <label>考试名称</label>
                <select class="ui dropdown" name="name">
                    <?php if(is_array($examRules)): $i = 0; $__LIST__ = $examRules;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>" class="examRule" ><?php echo ($vo["name"]); ?> (<?php echo ($vo["per"]); ?>%) </option><?php endforeach; endif; else: echo "" ;endif; ?>
                </select>
            </div>
            <div class="three wide field">
                <label>分数</label>
                <input type="number" name="score">
            </div>
        </div>

        <button class="ui primary button save">
            <i class="add icon"></i>
           添加
        </button>

        <a href="<?php echo U('index');?>">返回</a>
    </form>

    <h4>当前学生：【<?php echo ($stu["sname"]); ?>】</h4>
    <table class="ui celled table">

        <thead>
        <tr>
            <th  width="2rem">
                <div class="ui ribbon label">
                    <div class="ui checkbox">
                        <input type="checkbox" name="example"><label></label>
                    </div>
                </div>
            </th>
            <th>考试名称</th>
            <th>成绩</th>
            <th>班级</th>
            <th>学期</th>
            <th>时间</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        <?php if(is_array($exams)): $i = 0; $__LIST__ = $exams;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr id="tr_<?php echo ($vo['id']); ?>">
                <td>
                    <div class="ui checkbox">
                        <input type="checkbox" name="">
                        <label></label>
                    </div>
                </td>
                <td><?php echo ($vo["name"]); ?></td>
                <td><?php echo ($vo["score"]); ?>*<?php echo ($vo["per"]); ?>%=<?php echo ($vo["result"]); ?></td>
                <td><?php echo ($vo["class"]); ?></td>
                <td><?php echo ($vo["term"]); ?></td>
                <td><?php echo ($vo["ctime"]); ?></td>
                <td>
                    <button  onclick="{if(confirm('确定要删除吗?')){del('<?php echo ($vo["id"]); ?>'); }else{}}" class="mini ui negative button" id="delExam">删除</button>
                </td>
            </tr><?php endforeach; endif; else: echo "" ;endif; ?>
        </tbody>
        <tfoot>
        <tr>
            <th colspan="10">
                <div id="pages">
                    <?php if(is_array($examsum)): $i = 0; $__LIST__ = $examsum;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; echo ($vo["term"]); ?>考试成绩：<b>[<?php echo ($vo["perterm"]); ?>]</b>分&nbsp;<?php endforeach; endif; else: echo "" ;endif; ?>
                </div>
            </th>
        </tr>
        </tfoot>
    </table>





<script>
$('.dropdown').dropdown();

//删除考试
function del(id){
    var tr_id = '#tr_'+id;
  //  console.log(tr_id);


    var url = "<?php echo U('index',['opt'=>'delExam'],'');?>/id/"+id;
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

$('#add_fm').form({
    on: 'blur',
    inline: true,
    fields:{
    score: {
        identifier: 'score',
        rules: [
            {
                type: 'empty',
                prompt: '{name}不能为空！'
            },
            {
                type   : 'integer[0..100]',
                prompt : '{name}1-100数字！'
            },
        ]
    },
  }
});



$('.examRule').each(function(k,v){
    // console.log(v);
    if(jQuery.inArray(v.value,'<?php echo ($stuexams); ?>')!='-1'){
        $(v).prop('disabled','true');
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
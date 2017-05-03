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
		
<html>
<head>
<meta charset="UTF-8" />
<title>首页管理</title>
<script src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="http://code.highcharts.com/highcharts.js"></script>
<script src="http://code.highcharts.com/highcharts-3d.js"></script>
</head>
<body>
<div id="container" style="width: 550px; height: 400px; margin: 0 auto"></div>
<div id="sliders">
<table>
   <tr><td>Alpha Angle</td><td><input id="R0" type="range" min="0" max="45" value="15"/> <span id="R0-value" class="value"></span></td></tr>
   <tr><td>Beta Angle</td><td><input id="R1" type="range" min="0" max="45" value="15"/> <span id="R1-value" class="value"></span></td></tr>
</table>
</div>
<script language="JavaScript">
$(document).ready(function() {  
   var chart = {
      renderTo: 'container',
      type: 'column',
      margin: 75,
      options3d: {
         enabled: true,
         alpha: 15,
         beta: 15,
         depth: 50,
         viewDistance: 25
      }
   };
   var title = {
      text: '班级整体情况概览'
   };
   var subtitle = {
      text: '通过拖动下面的滑块测试'  
   };
   
   var plotOptions = {
      column: {
         depth: 25
      }
   };
   var series= [{
      data: [29.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4]
   }];     
      
   var json = {};   
   json.chart = chart; 
   json.title = title;   
   json.subtitle = subtitle;    
   json.series = series;
   json.plotOptions = plotOptions;
   var highchart = new Highcharts.Chart(json);
  
   function showValues() {
      $('#R0-value').html(highchart.options.chart.options3d.alpha);
      $('#R1-value').html(highchart.options.chart.options3d.beta);
   }

   // Activate the sliders
   $('#R0').on('change', function () {
      highchart.options.chart.options3d.alpha = this.value;
      showValues();
      highchart.redraw(false);
   });
   $('#R1').on('change', function () {
      highchart.options.chart.options3d.beta = this.value;
      showValues();
      highchart.redraw(false);
   });

   showValues();
});
</script>
</body>
</html>

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
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
                <img src="http://127.0.0.1/Uploads/<?php echo ($stu['sphoto']); ?>"/>
                <?php echo session('loginStudentName');?></a>
            <a href="<?php echo U('login/index',['opt'=>'loginout']);?>" style="color:#090909;font-size:14px">退出</a>
        </div>
    </div>

    <div class="row">
        <div class="sixteen wide column">


            <div class="ui grid">
                <div class="three wide column">
                    <div class="ui card">
                        <div class="image">
                            <img src="/Uploads/<?php echo ($stu["mphoto"]); ?>">
                        </div>

                        <div class="content">
                            <a class="header"><i class="<?php echo ($stu[sex]==2?'female':'male'); ?> icon"></i><?php echo ($stu["sname"]); ?>[<?php echo ($stu["class"]); echo ($stu["term"]); ?>]</a>
                            <div class="meta">
                                <span class="date">创建:<?php echo ($stu["ctime"]); ?></span>
                            </div>
                            <div class="description">
                                <p><i class="volume control phone icon"></i><?php echo ($stu["tel"]); ?></p>
                                <p><i class="mail outline icon"></i><?php echo ($stu["email"]); ?></p>
                            </div>
                        </div>
                        <div class="extra content">
                            <a href="<?php echo U('index',['opt'=>'sendMail','sid'=>$stu['sid']]);?>"><i class="mail icon"></i>发送到邮箱</a>
                            <a href="<?php echo U('index',['opt'=>'download','sid'=>$stu['sid']]);?>"><i class="download icon"></i>导出</a>
                        </div>
                    </div>
                </div>

                <div class="thirteen wide column">

                    <h3 class="ui dividing header"><i class="bookmark icon"></i>扣分</h3>
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
                            <th>扣分项目</th>
                            <th>分值</th>
                            <th>班级</th>
                            <th>学期</th>
                            <th>时间</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if(is_array($deductions)): $i = 0; $__LIST__ = $deductions;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                                <td>
                                    <div class="ui checkbox">
                                        <input type="checkbox" name="">
                                        <label></label>
                                    </div>
                                </td>
                                <td><?php echo ($vo["rname"]); ?></td>
                                <td><?php echo ($vo["rvalue"]); ?></td>
                                <td><?php echo ($vo["class"]); ?></td>
                                <td><?php echo ($vo["term"]); ?></td>
                                <td><?php echo ($vo["ctime"]); ?></td>
                            </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                        </tbody>
                        <tfoot>
                        <tr>
                            <th colspan="10">
                                <div id="pages">
                                    <?php if(is_array($desum)): $i = 0; $__LIST__ = $desum;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; echo ($vo["term"]); ?>共计扣分：<b>[<?php echo ($vo["termsum"]); ?>]</b>分&nbsp;&nbsp;<?php endforeach; endif; else: echo "" ;endif; ?>
                                </div>
                            </th>
                        </tr>
                        </tfoot>
                    </table>

                    <h3 class="ui dividing header"><i class="bookmark icon"></i>考试</h3>
                    <table class="ui very basic collapsing celled table">
                        <thead>
                        <tr>
                            <th>考试名称</th>
                            <th>考试成绩</th>
                            <th>班级</th>
                            <th>学期</th>
                            <th>时间</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if(is_array($exams)): $i = 0; $__LIST__ = $exams;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                                <td><?php echo ($vo["name"]); ?></td>
                                <td>
                                    <?php echo ($vo["score"]); ?>分×<?php echo ($vo["per"]); ?>%=
                                    <b><?php echo ($vo["result"]); ?></b>分
                                </td>
                                <td><?php echo ($vo["class"]); ?></td>
                                <td><?php echo ($vo["term"]); ?></td>
                                <td><?php echo ($vo["ctime"]); ?></td>
                            </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                        </tbody>
                        <tfoot>
                        <tr>
                            <th colspan="5">
                                <?php if(is_array($examsum)): $i = 0; $__LIST__ = $examsum;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="ui mini statistic">

                                        <div class="label"><?php echo ($vo["term"]); ?></div>
                                        <div class="value">
                                            <?php echo ($vo["perterm"]); ?>分
                                        </div>

                                    </div><?php endforeach; endif; else: echo "" ;endif; ?>
                            </th>
                        </tr>
                        </tfoot>
                    </table>

                    <h3 class="ui dividing header"><i class="bookmark icon"></i>当前得分</h3>


                    <?php if(is_array($examsum)): $i = 0; $__LIST__ = $examsum;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i; if($desum[0] and $desum[1]): if(is_array($desum)): $i = 0; $__LIST__ = $desum;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if($v['term'] == $vo['term']): ?><div class="ui tiny statistic">
                                        <div class="label"><?php echo ($v["term"]); ?> </div>
                                        <div class="value">
                                            <?php echo ($v['perterm']+$vo['termsum']); ?>分
                                        </div>
                                    </div><?php endif; endforeach; endif; else: echo "" ;endif; endif; ?>
                        <?php if($desum[0] and !$desum[1]): if(is_array($desum)): $i = 0; $__LIST__ = $desum;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if($v['term'] == $vo['term']): ?><div class="ui tiny statistic">
                                        <div class="label"><?php echo ($v["term"]); ?> </div>
                                        <div class="value">
                                            <?php echo ($v['perterm']+$vo['termsum']); ?>分
                                        </div>
                                    </div>

                                    <?php else: ?>
                                    <div class="ui tiny statistic">
                                        <div class="label"><?php echo ($v["term"]); ?> </div>
                                        <div class="value">
                                            <?php echo ($v['perterm']); ?>分
                                        </div>
                                    </div><?php endif; endforeach; endif; else: echo "" ;endif; endif; ?>
                        <?php if(!$desum): ?><div class="ui tiny statistic">
                                <div class="label"><?php echo ($v["term"]); ?> </div>
                                <div class="value">
                                    <?php echo ($v['perterm']); ?>分
                                </div>
                            </div><?php endif; endforeach; endif; else: echo "" ;endif; ?>







        </div>
    </div>
</div>
</body>

</html>
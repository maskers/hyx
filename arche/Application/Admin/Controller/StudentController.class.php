<?php


namespace Admin\Controller;
use Common\Controller\BaseController;

class StudentController extends BaseController {
    private $student = '';
    public function __construct(){
        parent::__construct();
        $this->student = M('student');

    }

    public function index(){
        $opt = I('get.opt');
        switch ($opt){
            case 'showStudent':
                $this->showStudent();
                break;
            case 'addStudent':
                $this->addStudent();
                break;
            case 'doAddStudent':
                $this->doAddStudent();
                break;
            case 'same':
                $this->same();
                break;
            case 'edit':
                $this->editStudent();
                break;
            case 'doEditStudent':
                $this->doEditStudent();
                break;
            case 'delStudent':
                $this->delStudent();
                break;
            case 'deduction':
                $this->deduction();
                break;
            case 'addDeduction':
                $this->addDeduction();
                break;
            case 'delDeduction':
                $this->delDeduction();
                break;
            case 'exam':
                $this->exam();
                break;
            case 'addExam':
                $this->addExam();
                break;
            case 'delExam':
                $this->delExam();
                break;
            case 'detail':
                $this->detail();
                break;
            case 'download':
                $this->download();
                break;
            case 'mail':
                $this->mail();
                break;
            default:
                $this->showStudent();
        }
    }

    public function showStudent(){
        //分页
        $count = $this->student->count();
        $pagesize = 3;
        $page = new \Think\Page($count,$pagesize);
        $this->assign('pages',$page->show());

        $students = $this->student
            ->alias('s')
            ->field([
                's.sid',
                'g.name'=>'group',
                's.sname',
                's.tel',
                's.email',
                's.sphoto',
                's.mphoto',
                's.photo',
                'd1.name'=>'sex',
                'd2.name'=>'class',
                'd4.name'=>'term',
                'd3.name'=>'status',
                's.ctime',
            ])
            ->JOIN('__DICT__ d1 ON s.sex=d1.value and d1.field="sex" ')
            ->JOIN('__DICT__ d2 ON s.class=d2.value and d2.field="class"')
            ->JOIN('__DICT__ d4 ON s.term=d4.value and d4.field="term"')
            ->JOIN('__DICT__ d3 ON s.status=d3.value and d3.field="status" ')
            ->JOIN('__GROUP__ g ON s.group=g.id')
            ->page(I('get.p',1),$pagesize)
            ->select();
//dump($students);
        $this->assign('students',$students);
        $this->display('showStudent');
    }


    private function same(){
        $field = I('get.field');
        $value = I('get.value');
        if($this->student->where([$field=>$value])->find()){
            echo true;
        }else{
            echo false;
        }
    }

    private function addStudent(){
        $this->display('addStudent');
    }

    private function doAddStudent(){
        //dump(I('post.'));exit;
        //文件上传
        // print_r($GLOBALS);
        // ECHO '<HR>';
        // print_r($_FILES);
        if($_FILES){
            $upload = new \Think\Upload();// 实例化上传类
            $upload->rootPath  = './Uploads/'; // 设置附件上传根目录
            $upload->savePath  = ''; // 设置附件上传（子）目录
            $info = $upload->upload();
            if($info){
                // dump($info);
                $filename = $info['file']['savepath'].$info['file']['savename'];
                $mphoto = $info['file']['savepath'].'m_'.$info['file']['savename'];
                $sphoto = $info['file']['savepath'].'s_'.$info['file']['savename'];
                //生成缩略图
                $image = new \Think\Image();
                $image->open("./Uploads/".$filename);
                $image->thumb(80,80)->save("./Uploads/".$mphoto);
                $image->thumb(30,30)->save("./Uploads/".$sphoto);
                //组织添加数据
                $_POST['photo'] = $filename;
                $_POST['mphoto'] = $mphoto;
                $_POST['sphoto'] = $sphoto;
            }else{
                // echo $upload->getError();
                $this->error($upload->getError(),U('index',['opt'=>'showstudent'],''));
            }
        }

        if(D('student')->create()){
            D('student')->add();
            $this->success('添加成功',U('index',['opt'=>'showStudent'],''),0);
        }else{
            D('student')->getError();
            $this->error(D('student')->getError(),U('index',['opt'=>'showStudent'],''));
        }
    }

    private function editStudent(){
        // dump(I('get.'));
        $student = $this->student->find(I('get.id'));
        $this->assign('stu',$student);
        $this->display('editStudent');
    }

    private function doEditStudent(){
        $sid = I('post.sid');
        // print_r($_POST);
        // print_r($_FILES);exit;
        if($_FILES['file']['name']!=''){
            $upload = new \Think\Upload();// 实例化上传类
            $upload->rootPath  = './Uploads/'; // 设置附件上传根目录
            $upload->savePath  = ''; // 设置附件上传（子）目录
            $info = $upload->upload();
            if($info){
                // dump($info);
                $filename = $info['file']['savepath'].$info['file']['savename'];
                $mphoto = $info['file']['savepath'].'m_'.$info['file']['savename'];
                $sphoto = $info['file']['savepath'].'s_'.$info['file']['savename'];
                //生成缩略图
                $image = new \Think\Image();
                $image->open("./Uploads/".$filename);
                $image->thumb(80,80)->save("./Uploads/".$mphoto);
                $image->thumb(30,30)->save("./Uploads/".$sphoto);
                //组织添加数据
                $_POST['photo'] = $filename;
                $_POST['mphoto'] = $mphoto;
                $_POST['sphoto'] = $sphoto;
            }else{
                // echo $upload->getError();
                $this->error($upload->getError(),U('index',['opt'=>'showstudent'],''));
            }
        }
        // print_r($_POST);exit;
        if(D('student')->create()){
            D('student')->save();
            // echo "修改成功";
            $this->success('修改成功',U('index',['opt'=>'showStudent','sid'=>$sid],''),0);
        }else{
            // echo D('dict')->getError();echo "修改成功";
            $this->error(D('dict')->getError(),U('index',['opt'=>'showStudent','sid'=>$sid],''));
        }

    }

    private function delStudent(){
        $id = I('get.id');
        $stu = $this->student->fetchSql(false)->find($id);
        $dir1 = './Uploads/'.$stu['photo'];
        $dir2 = './Uploads/'.$stu['mphoto'];
        $dir3 = './Uploads/'.$stu['sphoto'];
        if((M('student')->delete(I('get.id')))){
            unlink($dir1);
            unlink($dir2);
            unlink($dir3);
            echo 1;
        }else{
            echo 2;
        }
    }

//扣分
    private function deduction(){
        $id = I('get.id');
        //学生信息
        $stu = $this->student->find($id);
        //扣分表
        $deductions = kfb($id);
        //扣分规则
        $derules = M('deduction_rule')->select();

        //学期扣的总分
        $desum = desum($id);
        // dump($desum);exit;


        $this->assign('desum',$desum);
        $this->assign('stu',$stu);
        $this->assign('deductions',$deductions);
        $this->assign('derules',$derules);
        $this->display('deduction');
    }

    private function addDeduction(){
        $sid = I('post.sid');
        // dump(I('post.'));
        if(D('deduction')->create()){
            D('deduction')->add();
            $this->success('扣分成功',U('index',['opt'=>'deduction','id'=>$sid]),0);
        }else{
            echo D('deduction')->getError();
            $this->error(D('deduction')->getError(),U('index'));
        }
    }

    private function delDeduction(){
        // dump(I('get.id'));
        if((M('deduction')->delete(I('get.id')))){
            echo 1;
        }else{
            echo 2;
        }
    }




//考试
    private function exam(){
        $sid = I('get.sid');
        if(!$sid){
            $this->error('学生不存在');
        }
        //获取学生信息
        $stu = $this->student->find($sid);
        //获取考试规则
        $term = $stu['term'];
        $examRules = M('exam_rule')->where(['group'=>$term])->select();

        //已经添加过的考试
        $arr = M('exam')->field('name')->where(['sid'=>$sid])->select();
        $stuexams = [];
        foreach($arr as $v){
            $stuexams[] = $v['name'];
        }
        //dump(($stuexams));

        //考试表
        $exams = ksb($sid);
        //dump($exams);

        //学期考试总分
        $examsum = examsum($sid);


        $this->assign('stu',$stu);
        $this->assign('examRules',$examRules);
        $this->assign('exams',$exams);
        $this->assign('stuexams',$stuexams);
        $this->assign('examsum',$examsum);
        $this->display('exam');
    }

//添加考试
    private function addExam(){
        $sid = I('post.sid');
        if(D('exam')->create()){
            D('exam')->add();
            $this->success('添加成功',U('index',['opt'=>'exam','sid'=>$sid]),0);
        }else{
            D('exam')->getError();
            $this->error(D('exam')->getError(),U('index'));
        }
    }
//删除考试
    private function delExam(){
       //  dump(I('get.id'));
        if((M('exam')->delete(I('get.id')))){
            echo 1;
        }else{
            echo 2;
        }
    }


//详情
    private function detail(){
        $sid = I('get.sid');
        //学生信息
        $stu = $this->student
            ->alias('s')
            ->field([
                's.sid',
                's.sname',
                's.tel',
                's.email',
                's.sphoto',
                's.mphoto',
                's.photo',
                'd2.name'=>'class',
                'd4.name'=>'term',
                's.ctime',
                's.sex'=>'sex',
            ])
            ->JOIN('__DICT__ d2 ON s.class=d2.value and d2.field="class"')
            ->JOIN('__DICT__ d4 ON s.term=d4.value and d4.field="term"')
            ->where(['sid'=>I('get.sid')])
            ->select();
        $stu = $stu[0];
        //扣分表
        $deductions = kfb($sid);
        // dump($deductions);exit;
        //各学期扣分
        $desum = desum($sid);
        //考试表
        $exams = ksb($sid);
        //dump($exams);

        //各学期考试总分
        $examsum = examsum($sid);
        // dump($desum);
        // dump($examsum);exit;

        //当前得分


        $this->assign('stu',$stu);
        $this->assign('exams',$exams);
        $this->assign('deductions',$deductions);
        $this->assign('desum',$desum);
        $this->assign('examsum',$examsum);
        $this->display('detail');
        //dump($stu);
    }

    //导出学生数据
        private function download(){
            $sid = I('get.sid');
            //学生信息
            $stu = $this->student
                ->alias('s')
                ->field([
                    's.sid',
                    's.sname',
                    's.tel',
                    's.email',
                    's.sphoto',
                    's.mphoto',
                    's.photo',
                    'd2.name'=>'class',
                    'd4.name'=>'term',
                    's.ctime',
                    's.sex'=>'sex',
                ])
                ->JOIN('__DICT__ d2 ON s.class=d2.value and d2.field="class"')
                ->JOIN('__DICT__ d4 ON s.term=d4.value and d4.field="term"')
                ->where(['sid'=>I('get.sid')])
                ->select();
            $list1 = kfb($sid);
            $list2 = ksb($sid);
            $list3 = desum($sid);
            $list4 = examsum($sid);
//dump($list3);
//dump($list4);
            vendor("PHPExcel.PHPExcel");//如果这里提示类不存在，肯定是你文件夹名字不对。

            $objPHPExcel = new \PHPExcel();//这里要注意‘\’ 要有这个。因为版本是3.1.2了。

            $objWriter = new \PHPExcel_Writer_Excel2007($objPHPExcel);//设置保存版本格式

            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
            $objPHPExcel->getActiveSheet()->setCellValue('A1', '姓名：');
            $objPHPExcel->getActiveSheet()->setCellValue('B1', $stu['sname']);
            $objPHPExcel->getActiveSheet()->mergeCells('A2:E2');
            $objPHPExcel->getActiveSheet('0')->setCellValue('A2',  '扣分表');
            $objPHPExcel->getActiveSheet('0')->setCellValue('A3',  '扣分项目');
            $objPHPExcel->getActiveSheet('0')->setCellValue('B3', '分值');
            $objPHPExcel->getActiveSheet('0')->setCellValue('C3', '班级');
            $objPHPExcel->getActiveSheet('0')->setCellValue('D3', '学期');
            $objPHPExcel->getActiveSheet('0')->setCellValue('E3', '时间');
            $i=3;
            foreach ($list1 as $key => $value) {
                $i++;//表格是从1开始的
                $objPHPExcel->getActiveSheet('1')->setCellValue('A'.$i,  $value['rname']);
                $objPHPExcel->getActiveSheet('1')->setCellValue('B'.$i,  $value['rvalue']);
                $objPHPExcel->getActiveSheet('1')->setCellValue('C'.$i,  $value['class']);
                $objPHPExcel->getActiveSheet('1')->setCellValue('D'.$i,  $value['term']);
                $objPHPExcel->getActiveSheet('1')->setCellValue('E'.$i,  $value['ctime']);
            }
            $i++;
            $objPHPExcel->getActiveSheet()->mergeCells('A'.$i.':E'.$i);
            $objPHPExcel->getActiveSheet('0')->setCellValue('A'.$i, $list3[0]['term'].'共计扣分：'.
                $list3[0]['termsum'] .';'.$list3[1]['term'].'共计扣分：'. $list3[1]['termsum']);

            $i+=4;
            $objPHPExcel->getActiveSheet()->mergeCells('A'.$i.':E'.$i);
            $objPHPExcel->getActiveSheet('0')->setCellValue('A'.$i,  '考试表');
            $i++;
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$i,  '考试名称');
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$i, '考试成绩');
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$i, '班级');
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$i, '学期');
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$i, '时间');


            foreach ($list2 as $key => $value) {
                $i++;//表格是从1开始的
                $objPHPExcel->getActiveSheet()->setCellValue('A'.$i,  $value['name']);
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$i,  $value['score'].'分*'.$value['per'].'%='.$value['result']);
                $objPHPExcel->getActiveSheet()->setCellValue('C'.$i,  $value['class']);
                $objPHPExcel->getActiveSheet()->setCellValue('D'.$i,  $value['term']);
                $objPHPExcel->getActiveSheet()->setCellValue('E'.$i,  $value['ctime']);
            }

            $i++;
            $objPHPExcel->getActiveSheet()->mergeCells('A'.$i.':E'.$i);
            $objPHPExcel->getActiveSheet('0')->setCellValue('A'.$i, $list4[0]['term'].'考试得分：'.
                $list4[0]['perterm'] .';'.$list4[1]['term'].'考试得分：'. $list4[1]['perterm']);




            header("Pragma: public");
            header("Expires: 0");
            header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
            header("Content-Type:application/force-download");
            header("Content-Type:application/vnd.ms-execl");
            header("Content-Type:application/octet-stream");
            header("Content-Type:application/download");;
            header('Content-Disposition:attachment;filename=student.xlsx');
            header("Content-Transfer-Encoding:binary");
            // $objWriter->save('student.xlsx');
            $objWriter->save('php://output');
        }

    //发送邮箱
    private function mail(){
        $sid = I('get.sid');
        $stu = $this->student
            ->alias('s')
            ->field([
                's.sid',
                's.sname',
                's.tel',
                's.email',
                's.sphoto',
                's.mphoto',
                's.photo',
                'd2.name' => 'class',
                'd4.name' => 'term',
                's.ctime',
                's.sex' => 'sex',
            ])
            ->JOIN('__DICT__ d2 ON s.class=d2.value and d2.field="class"')
            ->JOIN('__DICT__ d4 ON s.term=d4.value and d4.field="term"')
            ->where(['sid' => I('get.sid')])
            ->find();
        $list1 = kfb($sid);
        $list2 = ksb($sid);
        $list3 = desum($sid);
        $list4 = examsum($sid);
//dump($list3);
//dump($list4);
        vendor("PHPExcel.PHPExcel");//如果这里提示类不存在，肯定是你文件夹名字不对。

        $objPHPExcel = new \PHPExcel();//这里要注意‘\’ 要有这个。因为版本是3.1.2了。

        $objWriter = new \PHPExcel_Writer_Excel2007($objPHPExcel);//设置保存版本格式

        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet()->setCellValue('A1', '姓名：');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', $stu['sname']);
        $objPHPExcel->getActiveSheet()->mergeCells('A2:E2');
        $objPHPExcel->getActiveSheet('0')->setCellValue('A2', '扣分表');
        $objPHPExcel->getActiveSheet('0')->setCellValue('A3', '扣分项目');
        $objPHPExcel->getActiveSheet('0')->setCellValue('B3', '分值');
        $objPHPExcel->getActiveSheet('0')->setCellValue('C3', '班级');
        $objPHPExcel->getActiveSheet('0')->setCellValue('D3', '学期');
        $objPHPExcel->getActiveSheet('0')->setCellValue('E3', '时间');
        $i = 3;
        foreach ($list1 as $key => $value) {
            $i++;//表格是从1开始的
            $objPHPExcel->getActiveSheet('1')->setCellValue('A' . $i, $value['rname']);
            $objPHPExcel->getActiveSheet('1')->setCellValue('B' . $i, $value['rvalue']);
            $objPHPExcel->getActiveSheet('1')->setCellValue('C' . $i, $value['class']);
            $objPHPExcel->getActiveSheet('1')->setCellValue('D' . $i, $value['term']);
            $objPHPExcel->getActiveSheet('1')->setCellValue('E' . $i, $value['ctime']);
        }
        $i++;
        $objPHPExcel->getActiveSheet()->mergeCells('A' . $i . ':E' . $i);
        $objPHPExcel->getActiveSheet('0')->setCellValue('A' . $i, $list3[0]['term'] . '共计扣分：' .
            $list3[0]['termsum'] . ';' . $list3[1]['term'] . '共计扣分：' . $list3[1]['termsum']);

        $i += 4;
        $objPHPExcel->getActiveSheet()->mergeCells('A' . $i . ':E' . $i);
        $objPHPExcel->getActiveSheet('0')->setCellValue('A' . $i, '考试表');
        $i++;
        $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, '考试名称');
        $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, '考试成绩');
        $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, '班级');
        $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, '学期');
        $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, '时间');


        foreach ($list2 as $key => $value) {
            $i++;//表格是从1开始的
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $value['name']);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $value['score'] . '分*' . $value['per'] . '%=' . $value['result']);
            $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $value['class']);
            $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $value['term']);
            $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $value['ctime']);
        }

        $i++;
        $objPHPExcel->getActiveSheet()->mergeCells('A' . $i . ':E' . $i);
        $objPHPExcel->getActiveSheet('0')->setCellValue('A' . $i, $list4[0]['term'] . '考试得分：' .
            $list4[0]['perterm'] . ';' . $list4[1]['term'] . '考试得分：' . $list4[1]['perterm']);
        $objWriter->save('student.xlsx');


        //发送到邮箱
        set_time_limit(0);//设置脚本执行超时时间
        include("/Email/phpmailer/PHPMailerAutoload.php");

        $mail = new \PHPMailer;
        //https://
        //邮件服务器信息配置
        $mail->ISSMTP();  //设置邮件发送协议 smtp|pop3|imap
        $mail->CharSet = "utf-8";  //设置邮件编码
        $mail->SMTPSecure = "ssl";  // SMTP 安全协议
        $mail->Port = 465;          // 邮件端口
        $mail->Host = "smtp.qq.com"; // 使用的邮件服务器

        $mail->SMTPAuth = true;  //设置phpmail发送邮件是否需要验(username&password)
        if ($mail->SMTPAuth) {
            $mail->Username = "masker025@qq.com";
            $mail->Password = 'jivwhevksvuwbcch';//密码
        }
        $mail->From = "masker025@qq.com";    //来源from
        $mail->IsHTML(true); // 是否发送html邮件

        $mail->AddAttachment('./student.xlsx', $stu['sname'].'.xlsx'); // 添加附件,并指定名称

        //发送邮件信息
        $mail->Addaddress($stu['email']); // 收件人
        $mail->FromName = 'masker';//发送人姓名
        $mail->Subject = '学生信息';   // 标题
        $mail->Body = '<b>学生信息</b>';    // 内容
        if ($mail->send()) {
            $this->success('发送成功',U('index'));
        } else {
            echo $mail->ErrorInfo;
        }
    }
}
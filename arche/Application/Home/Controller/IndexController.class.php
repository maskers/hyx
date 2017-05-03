<?php


namespace Home\Controller;
use Think\Controller;

class IndexController extends Controller {
    private $student = null;
    public function __construct(){
        parent::__construct();
        $this->student = M('student');
    }
    public function index(){
        //print_r($_SESSION);
        if(!$_SESSION){
            $this->error('你还没登录，请先登录',U('Home/Login/index'));
        }
        $opt = I('get.opt');
        switch ($opt){
            case 'detail':
                $this->detail();
                break;
            case 'download':
                $this->download();
                break;
            case 'sendMail':
                $this->sendMail();
                break;
            default:
                $this->detail();
        }
    }
    private function detail(){
        $sid =$_SESSION['loginStudentInfo']['sid'];
        //学生信息
        $stu = M('student')
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
            ->where(['sid'=>$sid])
            ->select();
        $stu = $stu[0];
        //扣分表
        $deductions = kfb($sid);
        //dump($deductions);
        //各学期扣分
        $desum = desum($sid);
        //考试表
        $exams = ksb($sid);
        //dump($exams);

        //各学期考试总分
        $examsum = examsum($sid);
//        dump($desum);
//         dump($examsum);

        //当前得分


        $this->assign('stu',$stu);
        $this->assign('exams',$exams);
        $this->assign('deductions',$deductions);
        $this->assign('desum',$desum);
        $this->assign('examsum',$examsum);
        $this->display('detail');
        //dump($stu);
    }
    private function sendMail(){
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
        $mail->FromName = $_SESSION['loginStudent'];//发送人姓名
        $mail->Subject = '得分详情';   // 标题
        $mail->Body = '<b>得分详情</b>';    // 内容
        if ($mail->send()) {
            $this->success('发送成功',U('index'));
        } else {
            echo $mail->ErrorInfo;
        }
    }
    private function download(){
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
                'd2.name'=>'class',
                'd4.name'=>'term',
                's.ctime',
                's.sex'=>'sex',
            ])
            ->JOIN('__DICT__ d2 ON s.class=d2.value and d2.field="class"')
            ->JOIN('__DICT__ d4 ON s.term=d4.value and d4.field="term"')
            ->where(['sid'=>I('get.sid')])
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
}
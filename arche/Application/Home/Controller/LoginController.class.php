<?php


namespace Home\Controller;
use Think\Controller;

class LoginController extends Controller {
    private $student = null;
    public function __construct(){
        parent::__construct();
        $this->student = M('student');
    }
    public function index(){
        $opt = I('get.opt');
        switch ($opt){
            case 'doLogin':
                $this->doLogin();
                break;
            case 'login':
                $this->login();
                break;
            case 'logout':
                $this->logout();
                break;
            case 'code':
                $this->code();
                break;
            case 'emailLogin':
                $this->emailLogin();
                break;
            case 'reset':
                $this->reset();
                break;
            case 'doreset':
                $this->doreset();
                break;
            case 'doemail':
                $this->doemail();
                break;
            default:
                $this->login();
        }
    }
    private function login(){
        $this->display('login');
    }
    //验证码
    public function code(){
        $config=[
            'fontSize'=>10,
            'length'=>3,
            'useCurve'=>true,
            'useNoise'=>false,
        ];
        $Verify = new \Think\Verify($config);
        $Verify->codeSet = '0123456789';
        $Verify->entry();

    }
    private function doLogin(){
        //验证码
        $code=I('post.code');
        $verify = new \Think\Verify();
        if($verify->check(I('post.code'))==false){
            $this->error('验证码输入错误',U('index'));
        }

        $where1 = [
            's.sname'=>I('post.name'),
            's.email'=>I('post.name'),
            's.tel'=>I('post.name'),
            '_logic'=>'or'
        ];
        $pwd = md5(I('post.pwd'));
        $where = ['_complex'=>$where1,'s.pwd'=>$pwd];
        $student = $this->student
            ->field([
                's.sname'=>'name',
                'g.name'=>'role',
                's.sid'=>'sid',
            ])
            ->alias('s')
            ->join('__GROUP__ g on s.group = g.id')
            ->where($where)->find();
        if($student){
            session('loginStudentName',$student['name']);
            session('loginStudentInfo',$student);
            $this->success('登陆成功',U('Home/Index/index'));
        }else{
            $this->error('登陆失败',U('Home/Login/index'));
        }
    }
    private function logout(){
        session_destroy();
        session(null); // 清空当前的session
        if(!session('?loginInfo')){
            $this->success('退出成功',U('Home/Login/index'));
            exit;
        }else{
            $this->error('退出失败',U('Home/Index/index'));
            exit;
        }
    }
    private function emailLogin(){
        $this->display('emailLogin');
    }
    //忘记密码登陆
    private function doemail(){
//        print_r(I('post.'));
//        exit;
        $student=$this->student
            ->alias('s')
            ->field([
                's.name',
                's.id',
                'g.name'=>'gname',
                'g.rule'
            ])
            ->join('__GROUP__ g ON s.group=g.id')
            ->where(['s.name'=>I('post.name'),'email'=>I('post.email')])->find();

        if($_POST['ecode']=$_SESSION['ecode']&&$student){
            $this->success('验证成功',U('Home/Login/index',['opt'=>'reset','id'=>$student['id']]));
        }else{
            $this->error('用户名或邮箱或验证码不正确');
        }
    }

    //重置密码
    private function reset(){
        $id=I('get.id');
        $this->assign('id',$id);
        $this->display('reset');
    }


    private function doreset(){
        $where['pwd']=md5(I('post.confirm_password'));
        if(I('post.')){
            $this->student->where(['id'=>I('post.id')])->save($where);
            $this->success('修改成功',U('index'));
        }else{
            $this->error('修改失败');
        }
    }
}
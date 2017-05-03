<?php
namespace Admin\Controller;
use Think\Controller;
class LoginController extends Controller {
	private $teahcer = null;
    public function __construct(){
    	parent::__construct();
    	$this->teacher = M('teacher');
    }
    public function index(){
    	$opt = I('get.opt');
        switch ($opt){
        	case 'check':
        		break;
        	case 'login':
        		$this->login();
        		break;
            case 'code':
                $this->code();
                break;
        	case 'doLogin':
        		$this->doLogin();
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
        	case 'logout':
        		$this->logout();
        		break;
        	default:
        		$this->login();
        }


    }

    private function login(){
    	$this->display('login');
    }

    private function doLogin(){
        $code=I('post.code');
        $verify = new \Think\Verify();
        if(!$verify->check($code)){
            $this->error('验证码输入错误','');
        }
        $where1 = [
            't.name'=>I('post.name'),
            'email'=>I('post.name'),
            'tel'=>I('post.name'),
            '_logic'=>'or'
        ];
        $where=[
            'pwd'=>md5(I('post.pwd')),
            '_complex'=>$where1
        ];

        $teacher=$this->teacher
            ->alias('t')
            ->field([
                't.name',
                'g.name'=>'gname',
                't.sphoto'=>'photo',
                'g.rule'
            ])
            ->join('__GROUP__ g ON t.group=g.id')
            ->where($where)->find();
    	// print_r($teacher);
    	if($teacher){
    		session('loginUser',$teacher['name']);
    		session('loginInfo',$teacher);
    		$this->success('登陆成功',U('Index/index'));
    	}else{
    		$this->error('登陆失败',U('index'));
    	}
    }
    //设置验证码
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

    //忘记密码界面
    private function emailLogin(){
        $this->display('emailLogin');
    }
    //忘记密码登陆
    private function doemail(){
//        print_r(I('post.'));
//        exit;
    $teacher=$this->teacher
            ->alias('t')
            ->field([
                't.name',
                't.id',
                'g.name'=>'gname',
                'g.rule'
            ])
            ->join('__GROUP__ g ON t.group=g.id')
            ->where(['t.name'=>I('post.name'),'email'=>I('post.email')])->find();

        if($_POST['ecode']=$_SESSION['ecode']&&$teacher){
            $this->success('验证成功',U('Login/index',['opt'=>'reset','id'=>$teacher['id']]));
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
            $this->teacher->where(['id'=>I('post.id')])->save($where);
            $this->success('修改成功',U('index'));
        }else{
            $this->error('修改失败');
        }
    }

    //退出登录
    private function logout(){
    	// session(['destroy']);
    	session_destroy();
    	session(null); // 清空当前的session
    	if(!session('?loginUser')){
			$this->success('退出成功',U('index'));
			exit;
		}
    }




}
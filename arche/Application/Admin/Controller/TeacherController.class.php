<?php
namespace Admin\Controller;
use Common\Controller\BaseController;
class TeacherController extends BaseController {
    private $teacher='';
    public function __construct(){
        parent::__construct();
        $this->teacher = M('teacher');
    }
    
    public function index(){
    	$opt = I('get.opt');
        switch ($opt){
        	case 'same':
                $this->same();
                break;
            case 'doAddTeacher':
                $this->doAddTeacher();
                break;
            case 'showTeacher':
                $this->showTeacher();
                break;
            case 'edit':
                $this->editTeacher();
                break;
            case 'doEdit':
                $this->doEditTeacher();
                break;
            case 'delTeacher':
                $this->delTeacher();
                break;
            default:
        	   $this->showTeacher();
        }
    }

    public function showTeacher(){
        //分页
        $count = $this->teacher->count();
        $pagesize = 3;
        $page = new \Think\Page($count,$pagesize);
        $this->assign('pages',$page->show());

        $teachers = $this->teacher
        ->alias('t')
        ->field([
            't.id',
            'g.name'=>'group',
            't.name',
            't.tel',
            't.email',
            't.sphoto',
            't.mphoto',
            't.photo',
            'd1.name'=>'sex',
            'd2.name'=>'class',
            'd3.name'=>'status',
            't.ctime',
            ])
        ->JOIN('__DICT__ d1 ON t.sex=d1.value and d1.field="sex" ')
        ->JOIN('__DICT__ d2 ON t.class=d2.value and d2.field="class"')
        ->JOIN('__DICT__ d3 ON t.status=d3.value and d3.field="status" ')
        ->JOIN('__GROUP__ g ON t.group=g.id')
        ->page(I('get.p',1),$pagesize)
        ->select();
// dump($teachers);
        $this->assign('teachers',$teachers);
    	$this->display('showTeacher');
    }


    private function same(){
        $field = I('get.field');
        $value = I('get.value');
        if($this->teacher->where([$field=>$value])->find()){
            echo true;
        }else{
            echo false;
        }
    }

    private function doAddTeacher(){
        //文件上传
        // print_r($GLOBALS);
        // print_r($_FILES);
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
            //echo $upload->getError();
            $this->error($upload->getError(),U('index',['opt'=>'showTeacher'],''));
        }

        if(D('teacher')->create()){
            D('teacher')->add();
            $this->success('添加成功',U('index',['opt'=>'showTeacher'],''),0);
        }else{
            D('teacher')->getError();
            $this->error(D('teacher')->getError(),U('index',['opt'=>'showTeacher'],''));
        }
    }

    private function editTeacher(){
        if(IS_AJAX){
            $id = I('get.id');
            $res = $this->teacher->find($id);
            $this->ajaxReturn($res);
        }
    }

    private function doEditTeacher(){
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
                $this->error($upload->getError(),U('index',['opt'=>'showTeacher'],''));
            }
        }
        // print_r($_POST);exit;
        if(D('teacher')->create()){
           D('teacher')->save();
           $this->success('修改成功',U('index',['opt'=>'showTeacher'],''),0);
        }else{
            D('dict')->getError();
            $this->error(D('dict')->getError(),U('index',['opt'=>'showTeacher'],''));
        }

    }

    private function delTeacher(){
        $id = I('get.id');
        $tea = $this->teacher->find($id);
        $dir1 = './Uploads/'.$tea['photo'];
        $dir2 = './Uploads/'.$tea['mphoto'];
        $dir3 = './Uploads/'.$tea['sphoto'];
        
        if((M('teacher')->delete(I('get.id')))){
            unlink($dir1);
            unlink($dir2);
            unlink($dir3);
            echo 1;
        }else{
            echo 2;
        }
    }


}
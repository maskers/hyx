<?php
namespace Admin\Controller;
use Common\Controller\BaseController;
class GroupController extends BaseController {
    private $group = null;
	public function __construct(){
    	parent::__construct();
        $this->group = M('group');
    }

    public function index(){
    	$opt = I('get.opt');
        switch ($opt){
            case 'doAddGroup':
                $this->doAddGroup();
                break;
            case 'doEditGroup':
                $this->doEditGroup();
                break;
            case 'delGroup':
                $this->delGroup();
                break;
        	default:
        	$this->showGroup();
        }
    }

    private function showGroup(){
        //分页
        $count = M('group')->count();
        // $page = new \Think\Page($count,2);//实现分页列表的输出
        // $pagenums = $page->show();
        $p = I('get.p',1);
        if($p<=0){
            $p=1;
        }
        if($p>ceil($count/2)){
            $p=ceil($count/2);
        }
        $groups = $this->group->page($p,2)->select();
        // echo ceil($count/2);
        $this->assign('pages',ceil($count/2));
        $this->assign('p',$p);
        // $this->assign('pagenums',$pagenums);
        if(IS_AJAX){
            $this->ajaxReturn($res);
        }else{
            $this->assign('groups',$groups);
            $this->display('showGroup');
        }
       
    }

    private function doAddGroup(){
        // dump(I('post.'));
        if(D('group')->create()){
            D('group')->add();
            $this->success('添加成功',U('index',['opt'=>'showGroup'],''),0);
        }else{
            D('group')->getError();
            $this->error(D('group')->getError(),U('index',['opt'=>'showGroup'],''));
        }
    }

    private function doEditGroup(){
        $id = I('post.id');
        $where = ['id'=>$id];
        $data = [
            'name'=>I('post.name'),
            'rule'=>I('post.rule')
        ];
       // dump($data);die();
        if(D('group')->create()){
            D('group')->where($where)->save($data);
            $this->success('修改成功',U('index',['opt'=>'showGroup']));
        }else{
            $this->error(D('group')->getError(),U('index',['opt'=>'showGroup']));
        }
    }

    private function delGroup(){
        $id = I('get.id');
        if((M('group')->delete(I('get.id')))){
            echo 1;
        }else{
            echo 2;
        }
    }


}
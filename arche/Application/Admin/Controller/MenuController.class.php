<?php
namespace Admin\Controller;
use Common\Controller\BaseController;
class MenuController extends BaseController {
	private $menu = null;
    public function __construct(){
        parent::__construct();
        $this->menu = D('menu');
        $status = M('dict')->where(['field'=>'status'])->select();
        $this->assign('status',$status);
    }
//admin/menu/index/opt/add
    public function index(){
        $opt = I('get.opt');
        switch ($opt){
        	case 'addMenu':
	        	$this->addMenu();
	        	break;
	        case 'doAddMenu':
	        	$this->doAddMenu();
	        	break;
	        case 'delMenu':
	        	$this->delMenu();
	        	break;
	        case 'editMenu':
	        	$this->editMenu();
	        	break;
	        case 'doEditMenu':
	        	$this->doEditMenu();
	        	break;
	        default:
	       		$this->showMenu();
        }
    }

	private function addMenu(){
        echo 'hello';
    }

    private function showMenu(){
    	$menus = $this->menu
    	->field(['m.id','m.name','m.pid','url','sort','icon','di.name'=>'status'])
    	->alias('m')
    	->join('__DICT__ di on di.field="status" and m.status=di.value ')
    	->select();
    	// $menus = tree($menus);
    	// dump($menus);
    	$this->assign('menus',tree($menus));
        $this->display('showMenu');
    }

    private function doAddMenu(){
    	// dump(I('post.'));
    	if(D('menu')->create()){
			D('menu')->add();
			$this->success('添加成功',U('index',['opt'=>'showMenu'],''));
		}else{
			echo D('menu')->getError();
			$this->error(D('menu')->getError(),U('index',['opt'=>'showMenu'],''));
		}
    }

    private function delMenu(){
    	// echo I('get.id');
    	$id = I('get.id');
    	$count = M('menu')->where(['pid'=>"{$id}"])->count();
    	if($count==0&&(M('menu')->delete(I('get.id')))){
    		echo 1;
    	}else{
    		echo 2;
    	}
    }

    private function editMenu(){
    	// echo I('get.id');
    	$id = I('get.id');
    	$count = M('menu')->where(['pid'=>"{$id}"])->count();
    	if($count==0){
    		echo 1;
    	}else{
    		echo 2;
    	}
    }

    private function doEditMenu(){
    	//dump(I('post.'));
		if(D('menu')->create()){
			D('menu')->save();
			$this->success('修改成功',U('index',['opt'=>'showMenu']));
		}else{
            D('teachers')->getError();
			$this->error('修改失败',U('index',['opt'=>'showMenu']));
		}
    }















}
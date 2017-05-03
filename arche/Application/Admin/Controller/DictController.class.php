<?php
namespace Admin\Controller;
use Common\Controller\BaseController;
class DictController extends BaseController {
	private $dict;
	public function __construct(){
    	parent::__construct();
    	$this->dict = D('dict');
    }

    public function index(){
    	$opt = I('get.opt');
        switch ($opt){
            case 'showDict':
                $this->showDict();
                break;
            case 'doAddDict':
                $this->doAddDict();
                break;
            case 'doEditDict':
                $this->doEditDict();
                break;
            case 'delDict':
                $this->delDict();
                break;
        	default:
        	$this->showDict();
        }
    }

	private function showDict(){
		//查询筛选字段
		$fields = $this->dict->field(["distinct(field) field"])->select();
		$this->assign('fields',$fields);
// dump($fields);
// print_r(I('post.field'));
		//获取筛选查询条件
		$where = [];
		if(I('post.field')){
			session('field',I('post.field'));
		}
		if(session('field')){
			$where['field'] = ['in',session('field')];
		}
// dump($where);

		//分页
		$count = $this->dict->where($where)->count();
		$pagesize = 6;
		$page = new \Think\Page($count,$pagesize);
		$show = $page->show();
		$this->assign('pages',$show);

		$dicts = $this->dict->where($where)->page(I('get.p',1),$pagesize)->select();
		$this->assign('dicts',$dicts);
		$this->display('showDict');
	}

	private function doAddDict(){
		// print_r($_POST);
		if(D('dict')->create()){
			$id =D('dict')->add();
			$this->success('添加成功',U('index',['opt'=>'showDict'],''),0);
		}else{
			$this->error(D('dict')->getError(),U('index',['opt'=>'showDict'],''));
		}
	}

	private function doEditDict(){
		// print_r($_POST);
		if(D('dict')->create()){
            D('dict')->save();
            $this->success('修改成功',U('index',['opt'=>'showDict'],''),0);
        }else{
            echo D('dict')->getError();
            $this->error(D('dict')->getError(),U('index',['opt'=>'showDict'],''));
        }
    }

    private function delDict(){
        $id = I('get.id');
        if((M('dict')->delete(I('get.id')))){
            echo 1;
        }else{
            echo 2;
        }
    }

}
<?php

namespace Common\Controller;

use \Think\Controller;

class BaseController extends Controller{
	public function __construct(){
		parent::__construct();
		$this->checkAuth();
		
		if(!session('loginInfo.rule')){
			$this->error('请先登录',U('Login/index'));
		}
		$menus = M('menu')->where([
			'status'=>1,
			'id'=>['in',session('loginInfo.rule')],
			])->select();
		$this->assign('navMenus',tree($menus));

		$sexs = $this->getFileds('sex');
		$this->assign('sexs',$sexs);
		$class = $this->getFileds('class');
		$this->assign('class',$class);
		$status = $this->getFileds('status');
		$this->assign('status',$status);
		$term = $this->getFileds('term');
		$this->assign('term',$term);
		$education = $this->getFileds('education');
		$this->assign('education',$education);
		
		$group = M('group')->select();
		$this->assign('group',$group);
	}


	public function getFileds($field){
		$res = M('dict')->where(['field'=>$field])->select();
		return $res;
	}

	public function verify(){
		$config =    array(
		    // 'fontSize'    =>    20,    // 验证码字体大小
		    'length'      =>    3,     // 验证码位数
		    // 'useNoise'    =>    false, // 关闭验证码杂点
		    // 'useImgBg'    =>    true, //背景图片\think2\ThinkPHP\Library\Think\Verify\bgs
		    // 'useCurve'    =>    true, //是否使用混淆曲线 默认为true
		    // 'fontttf'    =>    true, //	指定验证码字体 默认为随机获取
		    // 'useZh'    =>    true, //	是否使用中文验证码
		    // 'codeSet' => '0123456789',
		    // 'zhSet' => '我爱你',
		);
		$Verify = new \Think\Verify($config);
		$Verify->entry();
	}

	protected function checkAuth(){
		// echo "kkkkk";
		if(!C('CHECK_AUTH')){
			return;
		}
		if(session('?loginUser')==false){
			$this->error('您还未登录',U('Admin/Login/index'));
			
		}
    	$url = MODULE_NAME.'/'.CONTROLLER_NAME.'/'.ACTION_NAME;
    	$menu = M('menu')->where(['url'=>$url])->find();
    	$id = $menu['id'];
    	$rules = explode(',',session('loginInfo.rule'));
    	// print_r($rules);
    	if(!in_array($id,$rules)){
    		// $this->error('没有',U('Login/index'));
    		// print_r(session('loginInfo'));
    		die('没有权限访问！');

    	}
        // print_r(session(['loginInfo']));
    }
}
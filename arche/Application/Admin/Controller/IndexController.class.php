<?php
namespace Admin\Controller;
use Common\Controller\BaseController;
class IndexController extends BaseController {
	public function __construct(){
    	parent::__construct();
    }

    public function index(){
        $this->display('index');
        
    }


}
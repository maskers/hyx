<?php 

namespace Admin\Model;
use Think\Model;
class DeductionModel extends Model{


	public $_auto = [
		['ctime','formatTime',1,'callback'],
	];


	public function formatTime(){
		return date('Y-m-d H:i:s');
	}

}
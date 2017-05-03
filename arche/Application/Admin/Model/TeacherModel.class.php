<?php 

namespace Admin\Model;
use Think\Model;
class TeacherModel extends Model{

	public $_validate = [
		// ['role','lim2','角色0-8位数字',0,'callback'],

		['name','require','请填写用户名',0],
		['name','','用户名已经存在',0,'unique'],
		// ['name','/^[^\u0000-\u00FF]{2,6}$/','用户名2-6位汉字',0,'regex'],
		// ['name','/^[\x{4e00}-\x{9fa5}|a-z|A-Z]+$/u','用户名是字母或中文',0,'regex'],

		// ['nick','require','请填写昵称'],
		// ['nick','lim','用户名4-16位',0,'callback'],

		['tel','require','请填写手机号'],
		['tel','/^1[3|4|5|8][0-9]\\d{8,8}$/','手机号非法',0,'regex'],

		['email','require','请填写邮箱'],
		['email','email','邮箱验证失败'],
		['email','','邮箱已经存在',0,'unique'],

		['pwd','require','请填写密码',0,'',1],
		// ['pwd','2,16','密码在2-16位之间',0,'length'],
		['pwd','/^[A-Za-z0-9]{6,20}$/','密码6-20位字母数字组合',0,'regex'],

		['pwd2','pwd','输入密码不一致',0,'confirm'],

		// ['login_ip','/lim3/','登录ip地址错误',0,'function'],

	];

	public $_auto = [
		['status',1],
		['pwd','md5',1,'function'],
		['ctime','formatTime',1,'callback'],
		['mtime','formatTime',2,'callback'],
	];


	public function lim($str){
		return preg_match('/^[^\u0000-\u00FF]{2,6}$/',$str)==1?true:false;
	}
	public function lim2($str){
		return preg_match('/^[0-9]{0,8}$/',$str)==1?true:false;
	}
	public function lim3($str){
		return preg_match('/((?:(?:25[0-5]|2[0-4]\d|((1\d{2})|([1-9]?\d)))\.){3}(?:25[0-5]|2[0-4]\d|((1\d{2})|([1-9]?\d))))/',$str)==1?true:false;
	}
	public function formatTime(){
		return date('Y-m-d H:i:s');
	}

}
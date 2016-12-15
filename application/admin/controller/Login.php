<?php
namespace app\admin\controller;
use think\Controller;

class Login extends Controller
{
	//后台登录页面
	public function login()
	{
		return $this->fetch();
	}
}
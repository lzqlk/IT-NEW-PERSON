<?php
/**
 * 这是一个认证控制器
 */

namespace app\index\controller;

use think\Controller;
use think\Request;

class Auth extends Controller
{

	public function __construct(Request $request)
	{
		parent::__construct();
		// dump($request->controller());
		if(!$this->checkLogin() && $request->controller() != 'Auth')
		{
			$this->error('请登录');
		}
	}


	public function login()
	{

		return $this->fetch();
	}

	public function doLogin()
	{
		session('uid', 1);

		$this->redirect('Index/User/profile');
	}

	public function logout()
	{
		session(null);
	}

	public function register()
	{
		return $this->fetch();
	}

	public function doRegister()
	{

	}

	public function checkLogin()
	{
		return session('uid');
	}

}
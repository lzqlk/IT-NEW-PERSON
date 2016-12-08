<?php
namespace app\admin\controller;
use think\Controller;
use think\Request;
use app\admin\model\User;
class Auth extends Controller
{
	public function __construct(Request $request)
	{
		parent::__construct();
		if(!$this->checkLogin() && $request->controller() != 'Auth')
		{
			$this->error('请登录');
		}
	}

	public function login()
	{
		return $this->fetch();
	}

	public function doLogin(Request $request)
	{
		$username = $request->param('username');
		$password = md5($request->param('password'));
		$select = User::get(['username' => $username]);
	
		if ($select) {
			if ($select['password'] == $password) {
				session('username', $username);
				$this->redirect('admin/index/index');
			} else {
				$this->error('密码错误');
			}
		} else {
			$this->error('你不是管理员');
		}
	}

	public function logout()
	{
		session(null);
		$this->redirect('admin/index/login');
	}

	public function checkLogin()
	{
		return session('username');
	}
}
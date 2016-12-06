<?php
namespace app\admin\controller;
use think\Controller;
use app\admin\model\User;
use think\Request;
class Index extends Controller
{
	public function index()
	{
		$list = User::select();
		$soft = User::onlyTrashed()->select();
		$this->assign('list',$list);
		$this->assign('soft',$soft);
		return $this->fetch();
	}

	public function login()
	{
		return $this->fetch();
	}

	public function doLogin(Request $request)
	{
		$username = $request->param('username');
		$password = $request->param('password');
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

	public function link()
	{
		return $this->fetch();
	}
}
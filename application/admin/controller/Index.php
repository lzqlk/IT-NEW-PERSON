<?php
namespace app\admin\controller;
use think\Controller;
use app\admin\model\User;
use think\Request;
class Index extends Controller
{
	public function index()
	{
		$list = User::paginate(10);
		$this->assign('list',$list);
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
				$this->redirect('admin/index/index');
			} else {
				$this->error('密码错误');
			}
		} else {
			$this->error('你不是管理员');
		}

		session('username', $username);
	}
}
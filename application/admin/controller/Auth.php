<?php
/**
 * 这是一个认证控制器
 */
namespace app\admin\controller;
use think\Controller;
use think\Request;
use app\admin\model\Admin;
class Auth extends Controller
{
	//初始化 验证用户是否登录
	public function __construct(Request $request)
	{
		parent::__construct();
		if(!$this->checkLogin() && $request->controller() != 'Auth')
		{
			$this->error('请登录');
		}
	}
	//登录验证
	public function doLogin(Request $request)
	{
		$username = $request->param('username');
		$password = md5($request->param('password'));
		$select = Admin::get(['username' => $username]);
	
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
	//退出后台，返回登录页面
	public function logout()
	{
		session(null);
		$this->redirect('admin/login/login');
	}
	//防止用户在没有登录的情况下访问信息页面
	public function checkLogin()
	{
		return session('username');
	}
}
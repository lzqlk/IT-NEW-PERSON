<?php
/**
 * 这是一个认证控制器
 */

namespace app\index\controller;

use think\Controller;
use think\Request;
use think\Db;
use app\index\model\User;
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

	public function doLogin(Request $request)
	{

		$data = [
			'username'=>$request->param('username'),
			'password'=>md5($request->param('password')),
		];
		$sel =User::get(['username'=> $data['username']])->toArray();
		//dump($sel);die();
		if($sel) {
			if($data['password'] != $sel['password']) {
				$this->error('密码错误');
			}
		} else {
			$this->error('用户名不存在');
		}
		$this->redirect('Index/index/index');
	}

	public function logout()
	{
		session(null);
	}

	public function register()
	{
		return $this->fetch();
	}

	public function doRegister(Request $request)
	{
		$data = [
			'username'=>$request->param('username'),
			'password'=>md5($request->param('password')),
			'create_time'=>time()
		];
		$code = $request->param('verify');
		if(!captcha_check($code)){
			$this->error('验证码错误');
		};
		if(strlen($data['username']) < 6) {
			$this->error('没你这么玩的');
		} 
		if(strlen($data['password']) < 6) {
			$this->error('密码必须是6-18位的字符');
		}
		$in = User::create($data);
		if($in) {
			$this->redirect('Index/auth/login');
		}
		//dump($request->param('username'));
		//$this->redirect('Index/index/index');
	}

	public function checkLogin()
	{
		return session('uid');
	}

}
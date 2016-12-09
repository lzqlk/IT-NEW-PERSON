<?php
/**
 * 这是一个认证控制器
 */

namespace app\index\controller;

use think\Controller;
use think\Request;
use think\Db;
use app\index\model\User;
use app\index\model\Company;
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
		$name = $request->param('username');
		$pwd = md5($request->param('password'));
		$sel = User::get(['username'=> $name]);
		
		if($sel) {
			//验证求职者
			if($pwd != $sel['password']) {
				$this->error('密码错误');
			}
			session('username',$sel['username']);
			session('uid',$sel['uid']);
			session('photo',$sel['photo']);
			session('resume',$sel['resume']);
		} else {
			//验证企业
			$sel1 = Company::get(['cname'=> $name]);
			if($sel1) {
				if($pwd != $sel1['password']) {
					$this->error('密码错误');
				}
			session('username',$sel1['cname']);	

			} else {
				$this->error('用户名不存在');
			}
			
		}
		if(session('photo')) {
			$this->redirect('index/index/index');
		}
		$this->success('登录成功，请完善个人信息','Index/user/userinfo');
	}

	public function logout()
	{
		session(null);
		$this->redirect('index/index/index');
	}

	public function register()
	{
		return $this->fetch();
	}

	public function doRegister(Request $request)
	{
		$name = $request->param('username');
		$pwd = $request->param('password');
		$time = time();
	
		$code = $request->param('verify');
		$hidden = $request->param('hidden');
		$sel = User::get(['username'=> $name]);
		if($sel) {
			$this->error('用户名已存在');
		} else {
			$sel1 = Company::get(['cname'=> $name]);
			if($sel1) {
				$this->error('用户名已存在');
			}
		}
		if(strlen($name) < 6 || empty($name) || strlen($name) > 18) {
			$this->error('没你这么玩的');
		} 
		if(!captcha_check($code)){
			$this->error('验证码错误');
		};
		if(strlen($pwd) < 6 || strlen($pwd) > 18) {
			$this->error('密码必须是6-18位的字符');
		}

		$data = [
			'password'=>md5($pwd),
			'create_time'=>$time
		];
		

		if($hidden) {
			$data['cname'] = $name;
			$insert = Company::create($data);
		} else {
			$data['username'] = $name;
			$insert = User::create($data);
		}

		if($insert) {
			$this->redirect('Index/auth/login');
		}
		
	}
	/**
	 * 检验用户名是否被注册
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	public function checkName(Request $request)
	{

		$sel = User::get(['username'=> $request->param('username')]);
		$sel1 = Company::get(['cname'=> $request->param('username')]);
		if($sel || $sel1) {
			echo json_encode(array('status' => 1, 'msg' => '用户名已被注册'));
		} else {
			echo json_encode(array('status' => 0));
		}
		//echo json_encode($sel);
	}

	public function checkLogin()
	{
		return session('username');
	}

}
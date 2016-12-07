<?php
namespace app\index\controller;
use app\index\controller\Auth;
use think\Request;
use app\index\model\User;
use app\index\model\Company;
class User extends Auth
{
	public function userInfo()
	{
		$info = User::get(session('uid'))->toArray();
		//dump($info);die();
		$this->assign('info',$info);
		return $this->fetch();
	}
	/**
	 * 修改个人信息
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	public function update_info(Request $request)
	{
		$user = new User;
		//dump($request);die();
		
		//获取头像路径并验证
		$file = request()->file('photo');
		
		if($file) {
			$photo = $file->move(ROOT_PATH . 'public' . DS . 'uploads');

			if($photo){
				$photo1 = '__SITE__/uploads/'.$photo->getSaveName();
			} else {
				$this->error($file->getError());
			}
		} else {
			$photo1 = session('photo');
		}

		//验证手机号
		
		$phone = $request->param('phone_num');
		//dump($phone);die();
		$pattern = "/^1(3|4|5|7|8)\d{9}$/";
		/*$sel = User::get(['phone_num'=> $phone]);
		if($sel) {
			$this->error('该号码已被注册');
		}*/
		if($phone != '') {
			if (!preg_match($pattern, $phone,$match)) {
				$this->error('手机号错误');
			}
		}
		
		//验证邮箱
		$email = $request->param('email');
		$pattern1 = "/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/";
		/*$sel1 = User::get(['email'=> $email]);
		if($sel1) {
			$this->error('该邮箱已被注册');
		}*/
		if($email != '') {
			if (!preg_match($pattern1, $email,$match1)) {
				$this->error('邮箱格式错误');
			}
		}
		
		//链接数据库 更新数据库
		$user->save([
			'username'=>$request->param('username'),
			'sex'=>$request->param('sex'),
			'phone_num'=>$phone,
			'email'=>$email,
			'profession'=>$request->param('profession'),
			'self'=>$request->param('self'),
			'photo'=>$photo1,
			'update_time'=>time()
			],['uid'=>session('uid')]);
		session('photo',$photo1);
		session('username',$request->param('username'));
		$this->success('保存成功');
	}

	public function updatePwd()
	{
		$info = User::get(session('uid'))->toArray();
		//dump($info);die();
		$this->assign('info',$info);
		return $this->fetch();
	}

	public function update_pwd(Request $request)
	{
		$user = new User;
		//dump($request->param());die();
		$sel = User::get(['uid'=>session('uid')])->toArray();
		//dump($sel);die();
		$oldPwd = md5($request->param('oldpassword'));
		$newPwd = $request->param('newpassword');
		$comfirmPwd = $request->param('comfirmpassword');
		if ($oldPwd != $sel['password']) {
			$this->error('密码错误');
		}
		if($newPwd != $comfirmPwd) {
			$this->error('两次密码不相等');
		}

		$user->save([
			'password'=>md5($newPwd)
			],['uid'=>session('uid')]);
		$this->success('修改成功,请重新登录','index/auth/login', '', 1);
	}

	public function checkPwd(Request $request)
	{

		$sel = User::get(['uid'=>session('uid')])->toArray();
		$pwd = md5($request->param('password'));
		if($sel['password'] == $pwd) {
			echo json_encode(array('status' => 1, 'msg' => '正确'));
		} else {
			echo json_encode(array('status' => 0));
		}
	}

		/**
	 * 检验手机号是否被注册
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	/*public function checkPhoneNum(Request $request)
	{

		//$sel = User::get(['phone_num'=> $request->param('phone_num')]);
		if($sel) {
			echo json_encode(array('status' => 1, 'msg' => '该号码已被注册'));
		} else {
			echo json_encode(array('status' => 0));
		}
		//echo json_encode($sel);
	}*/
}
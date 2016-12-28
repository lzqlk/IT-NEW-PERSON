<?php
namespace app\admin\controller;
use think\Controller;
use app\admin\model\User as U;
use app\admin\model\Resume;
use app\admin\model\Admin;
use think\Db;
class User extends Auth
{
	//删除求职用户
	public function delete()
	{
		U::destroy(input('param.uid/a'));
		$this->redirect('admin/index/index');
	}
	//恢复求职用户回收站里的数据
	public function renew()
	{
		Db::name('user')->where('uid', 'in', input('param.uid'))->update(['delete_time' => NULL]);
	}
	//彻底删除求职用户回收站里的数据
	public function reldelete()
	{
		Db::name('user')->where('uid', input('param.uid'))->delete();
		$this->redirect('admin/index/index');
	}
	//对求职用户回收站里的数据进行型操作
	public function action()
	{
		if (input('param.btn')) {
			//批量彻底删除求职用户回收站里的数据
			Db::name('user')->where('uid', 'in', input('param.uid/a'))->delete();
		} else {
			//批量恢复求职用户回收站里的数据
			Db::name('user')->where('uid', 'in', input('param.uid/a'))->update(['delete_time' => NULL]);
		}
		$this->redirect('admin/index/index');
	}
	//管理员列表
	public function admin()
	{
		$admin = Admin::paginate(10);
		$soft = Admin::onlyTrashed()->paginate(10);
		$this->assign([
			'admin' => $admin,
			'soft' => $soft
			]);
		return $this->fetch();
	}
	//简历详情
	public function details()
	{
		$detail = Resume::get(input('param.id'));
		$this->assign('detail', $detail);
		return $this->fetch();
	}
	//添加管理员
	public function addAdmin()
	{
		//获取输入数据
		$name = input('param.username');

		$pwd = input('param.password');

		$email = input('param.email');

		$phone = input('param.phone');

		$time = time();

		$sel = Admin::get(['username'=> $name]);

		if($sel) {

			$this->error('用户名已存在');

		}

		//验证用户名
		if(strlen($name) < 6 || empty($name) || strlen($name) > 18) {

			$this->error('用户名必须是6~18位的字符');

		} 

		//验证密码
		if(strlen($pwd) < 6 || strlen($pwd) > 18) {

			$this->error('密码必须是6-18位的字符');

		}

		//验证手机号
		$pattern = "/^1(3|4|5|7|8)\d{9}$/";
		
		if($phone != '') {
			if (!preg_match($pattern, $phone, $match)) {
				$this->error('手机号错误');
			}
		}

		//验证邮箱
		$pattern1 = "/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/";
		
		if($email != '') {

			if (!preg_match($pattern1, $email, $match1)) {

				$this->error('邮箱格式错误');

			}
		}

		$data = [
			'username' => $name,

			'password'=> md5($pwd),

			'create_time'=>$time,

			'email' => $email,

			'phone' => $phone
		];
		
		$insert = Admin::create($data);

		if($insert) {

			$this->redirect('admin/user/admin');

		}
	}

	//移除管理员的所有权限
	public function deleteAdmin()
	{
		Admin::destroy(input('param.id'));
		$this->redirect('admin/user/admin');
	}
	//彻底删除管理员用户
	public function clear()
	{
		$val = input('param.id');
		Db::name('admin')->where('admin_id', input('param.id'))->delete();
	}

	//恢复管理员的所有权限
	public function renewAdmin()
	{
		Db::name('admin')->where('admin_id', input('param.id'))->update(['delete_time' => NULL]);
		$this->redirect('admin/user/admin');
	}
}
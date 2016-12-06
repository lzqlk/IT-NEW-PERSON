<?php
namespace app\admin\controller;
use think\Controller;
use app\admin\model\User;
use think\Db;
class User extends Controller
{
	public function delete()
	{
		User::destroy(input('param.uid'));
		$this->redirect('admin/index/index');
	}

	public function renew(User $user)
	{
		Db::name('user')->where('uid', input('param.uid'))->update(['delete_time' => NULL]);
		$this->redirect('admin/index/index');
	}

	public function reldelete()
	{
		Db::name('user')->where('uid', input('param.uid'))->delete();
		$this->redirect('admin/index/index');
	}

}
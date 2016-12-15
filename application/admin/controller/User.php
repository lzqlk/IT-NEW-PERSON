<?php
namespace app\admin\controller;
use think\Controller;
use app\admin\model\User;
use app\admin\model\Resume;
use think\Db;
class User extends Auth
{
	public function delete()
	{
		User::destroy(input('param.uid/a'));
		$this->redirect('admin/index/index');
	}

	public function renew()
	{
		Db::name('user')->where('uid', 'in', input('param.uid'))->update(['delete_time' => NULL]);
	}

	public function reldelete()
	{
		Db::name('user')->where('uid', input('param.uid'))->delete();
		$this->redirect('admin/index/index');
	}

	public function action()
	{
		if (input('param.btn')) {
			Db::name('user')->where('uid', 'in', input('param.uid/a'))->delete();
		} else {
			Db::name('user')->where('uid', 'in', input('param.uid/a'))->update(['delete_time' => NULL]);
		}
		$this->redirect('admin/index/index');
	}

	public function admin()
	{
		return $this->fetch();
	}

	public function details()
	{
		$detail = Resume::get(input('param.id'));
		$this->assign('detail', $detail);
		return $this->fetch();
	}
}
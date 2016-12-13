<?php
namespace app\admin\controller;
use think\Controller;
use app\admin\model\Resume;
use think\Db;

class Resume extends Auth
{
	public function action()
	{
		if (input('param.btn')) {
			Db::name('resume')->where('rid', 'in', input('param.uid/a'))->delete();
		} else {
			Db::name('resume')->where('rid', 'in', input('param.uid/a'))->update(['delete_time' => NULL]);
		}
		$this->redirect('admin/index/index');
	}
	
}
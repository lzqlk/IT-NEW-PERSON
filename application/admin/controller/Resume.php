<?php
namespace app\admin\controller;
use think\Controller;
use app\admin\model\Resume as Re;
use think\Db;

class Resume extends Auth
{
	//对简历回收站里的数据进行操作
	public function action()
	{
		if (input('param.btn')) {
			//彻底删除简历回收站里的数据
			Db::name('resume')->where('rid', 'in', input('param.uid/a'))->delete();
		} else {
			//恢复简历回收站里的数据
			Db::name('resume')->where('rid', 'in', input('param.uid/a'))->update(['delete_time' => NULL]);
		}
		$this->redirect('admin/index/index');
	}
	
}
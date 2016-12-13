<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use app\admin\model\Office;

class Office extends Auth
{
	public function delete()
	{
		Office::destroy(input('param.offer_id/a'));
		$this->redirect('admin/company/company');
	}

	public function action()
	{
		if (input('param.btn')) {
			Db::name('office')->where('offer_id', 'in', input('param.id/a'))->delete();
		} else {
			Db::name('office')->where('offer_id', 'in', input('param.id/a'))->update(['delete_time' => NULL]);
		}
		$this->redirect('admin/company/company');
	}
}
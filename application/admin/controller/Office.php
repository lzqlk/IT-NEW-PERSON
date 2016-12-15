<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use app\admin\model\Office;

class Office extends Auth
{
	//软删除企业发布的职位
	public function delete()
	{
		Office::destroy(input('param.offer_id/a'));
		$this->redirect('admin/company/company');
	}
	//对职位回收站里的数据进行操作
	public function action()
	{
		if (input('param.btn')) {
			//彻底删除职位回收站里的数据
			Db::name('office')->where('offer_id', 'in', input('param.id/a'))->delete();
		} else {
			//恢复职位回收站里的数据
			Db::name('office')->where('offer_id', 'in', input('param.id/a'))->update(['delete_time' => NULL]);
		}
		$this->redirect('admin/company/company');
	}
}
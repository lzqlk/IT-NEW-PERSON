<?php
namespace app\admin\controller;
use think\Controller;
use app\admin\model\Company;
use app\admin\model\Office;
use think\Db;
class Company extends Auth
{
	public function company()
	{
		$list = Company::paginate(10);
		$soft = Company::onlyTrashed()->paginate(10);
		$office = Office::paginate(10);
		$soft_office = Office::onlyTrashed()->paginate(10);
		$this->assign([
				'list'=>$list,
				'soft'=>$soft,
				'office' => $office,
				'soft_office' => $soft_office
			]);
		return $this->fetch();
	}

	public function delete()
	{
		Company::destroy(input('param.cid/a'));
		$this->redirect('admin/company/company');
	}

	public function action()
	{
		if (input('param.btn')) {
			Db::name('company')->where('cid', 'in', input('param.cid/a'))->delete();
		} else {
			Db::name('company')->where('cid', 'in', input('param.cid/a'))->update(['delete_time' => NULL]);
		}
		$this->redirect('admin/company/company');
	}

	public function review()
	{
		$val = input('param.select');
		Office::where('offer_id',$val)->update(['is_disabled' => 1]);
	}
}
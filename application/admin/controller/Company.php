<?php
namespace app\admin\controller;
use think\Controller;
use app\admin\model\Company;
use app\admin\model\Office;
use app\admin\model\Send;
use think\Db;
class Company extends Auth
{
	//企业管理页面
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
	//软删除企业用户
	public function delete()
	{
		Company::destroy(input('param.cid/a'));
		$this->redirect('admin/company/company');
	}
	//管理企业回收站里的数据
	public function action()
	{
		if (input('param.btn')) {
			//彻底删除回收站里的企业数据
			Db::name('company')->where('cid', 'in', input('param.cid/a'))->delete();
		} else {
			//恢复企业回收站里的数据
			Db::name('company')->where('cid', 'in', input('param.cid/a'))->update(['delete_time' => NULL]);
		}
		$this->redirect('admin/company/company');
	}
	//验证职位是否可以公开发布
	public function review()
	{
		$val = input('param.select');
		Office::where('offer_id',$val)->update(['is_disabled' => 1]);
	}
	//职位详情
	public function details()
	{
		$detail = Office::get(input('param.offer_id'));
		$this->assign('detail', $detail);
		return $this->fetch();
	}
	//设置或取消热门职位
	public function setHot()
	{
		if (input('param.btn')) {
			$hot = 1;
		} else {
			$hot = 0;
		}
		Office::where('offer_id', input('param.id'))->update(['is_hot' => $hot]);
	}
}
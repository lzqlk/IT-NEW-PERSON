<?php
namespace app\admin\controller;
use think\Controller;
use app\admin\model\Company;
class Company extends Auth
{
	public function company()
	{
		$list = Company::paginate(10);
		$soft = Company::onlyTrashed()->paginate(10);
		$this->assign([
				'list'=>$list,
				'soft'=>$soft
			]);
		return $this->fetch();
	}
}
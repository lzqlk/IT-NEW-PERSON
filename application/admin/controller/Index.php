<?php
namespace app\admin\controller;
use think\Controller;
use app\admin\model\User;
class Index extends Auth
{
	public function index()
	{
		$list = User::paginate(2);
		$soft = User::onlyTrashed()->paginate(2);
		$this->assign('list',$list);
		$this->assign('soft',$soft);
		return $this->fetch();
	}
}
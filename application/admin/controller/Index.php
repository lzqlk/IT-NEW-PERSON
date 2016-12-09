<?php
namespace app\admin\controller;
use think\Controller;
use app\admin\model\User;
class Index extends Auth
{
	public function index()
	{
		$list = User::paginate(10);
		$soft = User::onlyTrashed()->paginate(10);
		$this->assign('list',$list);
		$this->assign('soft',$soft);
		return $this->fetch();
	}
}
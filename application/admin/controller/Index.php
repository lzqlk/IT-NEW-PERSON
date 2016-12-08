<?php
namespace app\admin\controller;
use think\Controller;
use app\admin\model\User;
class Index extends Auth
{
	public function index()
	{
		$list = User::select();
		$soft = User::onlyTrashed()->select();
		$this->assign('list',$list);
		$this->assign('soft',$soft);
		return $this->fetch();
	}
}
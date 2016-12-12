<?php
namespace app\admin\controller;
use think\Controller;
use app\admin\model\User;
use app\admin\model\Resume;
class Index extends Auth
{
	public function index()
	{
		$list = User::paginate(10);
		$soft = User::onlyTrashed()->paginate(10);
		$resume = Resume::paginate(10);

		$this->assign([
			'soft' => $soft,
			'list' => $list,
			'resume' => $resume
			]);
		return $this->fetch();
	}
}
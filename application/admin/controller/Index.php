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
		$soft_resume = Resume::onlyTrashed()->paginate(10);

		$this->assign([
			'soft' => $soft,
			'list' => $list,
			'resume' => $resume,
			'soft_resume' => $soft_resume
			]);
		return $this->fetch();
	}

	public function review()
	{
		$val = input('param.select');
		Resume::where('rid',$val)->update(['is_disabled' => 1]);
	}

	public function delete()
	{
		Resume::destroy(input('param.rid'));
	}

	public function deleteResume()
	{
		$val = input('param.select');
		Resume::destroy($val);
	}
}
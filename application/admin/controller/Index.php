<?php
namespace app\admin\controller;
use think\Controller;
use app\admin\model\User;
use app\admin\model\Resume;
class Index extends Auth
{
	//求职者信息页面
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
	//验证简历是否可用
	public function review()
	{
		$val = input('param.select');
		Resume::where('rid',$val)->update(['is_disabled' => 1]);
	}
	//软删除求职者信息
	public function delete()
	{
		Resume::destroy(input('param.rid'));
	}
	//软删除简历
	public function deleteResume()
	{
		$val = input('param.select');
		Resume::destroy($val);
	}
}
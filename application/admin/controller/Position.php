<?php
namespace app\admin\controller;
use think\Controller;
use app\admin\model\Position as Po;
use app\admin\model\Industry;
class Position extends Auth
{
	//管理职位分类页面
	public function position()
	{
		$option = Industry::where('parentid', '<>', 0)->select();
		$this->assign('option',$option);

		$job = Po::select();
		$this->assign('job', $job);
		return $this->fetch();
	}
	//添加职位分类
	public function add()
	{
		Po::create(['p_name' => input('param.job_name'), 'iid' => input('param.select')]);
		$this->redirect('admin/position/position');
	}
	//设为热门分类或取消热门分类
	public function setHot()
	{
		if (input('param.btn')) {
			$hot = 1;
			$style = '#00B38A';
		} else {
			$hot = 0;
			$style = NULL;
		}
		Po::where('pid', input('param.id'))->update(['is_hot' => $hot,'style' => $style]);
	}
	//行业分类页面
	public function industry()
	{
		$big = Industry::where('parentid', '=', 0)->select();
		$small = Industry::where('parentid', '<>', 0)->select();
		$this->assign('big',$big);
		$this->assign('small',$small);
		return $this->fetch();
	}
	//添加行业分类
	public function addcate()
	{
		Industry::create(['name' => input('param.cate'), 'parentid' => input('param.select')]);
		$this->redirect('admin/position/industry');
	}
	//删除行业类别
	public function deleteIndustry()
	{
		Industry::destroy(input('param.id'));
	}
	//修改行业类别名称
	public function edit()
	{
		Industry::where('iid',input('param.id'))->update(['name' => input('param.value')]);
	}
	//删除职位类别
	public function deletePosition()
	{
		Po::destroy(input('param.id'));
	}
	//修改职位类别名称
	public function editPosition()
	{
		Po::where('pid',input('param.id'))->update(['p_name' => input('param.value')]);
	}
}
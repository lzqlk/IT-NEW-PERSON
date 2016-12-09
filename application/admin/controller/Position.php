<?php
namespace app\admin\controller;
use think\Controller;
use app\admin\model\Position;
use app\admin\model\Industry;
class Position extends Auth
{
	public function position()
	{
		$option = Industry::where('parentid', '<>', 0)->select();
		$this->assign('option',$option);

		$job = Position::select();
		$this->assign('job', $job);
		return $this->fetch();
	}

	public function add()
	{
		Position::create(['p_name' => input('param.job_name'), 'iid' => input('param.select')]);
		$this->redirect('admin/position/position');
	}

	public function setHot()
	{
		dump(input('param'));
		/*if (input('param.id')) {
			$hot = Position::where('pid', input('param.id'))->update(['is_hot' => 0]);
		} else {
			$hot = Position::where('pid', input('param.id'))->update(['is_hot' => 1]);
		}
		
		if ($hot) {
			echo json_encode(array('status' => 1));
		} else {
			echo json_encode(array('status' => 0));
		}*/
	}

	public function industry()
	{
		$big = Industry::where('parentid', '=', 0)->select();
		$small = Industry::where('parentid', '<>', 0)->select();
		$this->assign('big',$big);
		$this->assign('small',$small);
		return $this->fetch();
	}

	public function addcate()
	{
		Industry::create(['name' => input('param.cate'), 'parentid' => input('param.select')]);
		$this->redirect('admin/position/industry');
	}
}
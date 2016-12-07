<?php
namespace app\admin\controller;
use think\Controller;
use app\admin\model\Position;
class Position extends Auth
{
	public function position()
	{
		return $this->fetch();
	}
}
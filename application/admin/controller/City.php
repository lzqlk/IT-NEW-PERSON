<?php
namespace app\admin\controller;
use think\Controller;
use app\admin\model\City as C;
use think\Db;
class City extends Auth
{
	//城市管理页面
	public function city()
	{
		return $this->fetch();
	}
}
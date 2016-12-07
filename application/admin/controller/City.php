<?php
namespace app\admin\controller;
use think\Controller;
use app\admin\model\City;
use think\Db;
class City extends Auth
{
	public function city()
	{
		return $this->fetch();
	}
}
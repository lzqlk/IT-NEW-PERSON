<?php
namespace app\admin\controller;
use think\Controller;
use app\admin\model\Company;
class Company extends Auth
{
	public function company()
	{
		return $this->fetch();
	}
}
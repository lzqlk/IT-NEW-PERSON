<?php

namespace app\index\controller;
use think\Controller;
use app\index\model\Office;
use think\Db;
class Position extends Controller
{
	public function php()
	{
		return $this->fetch();
	}

	public function details()
	{
		$id = explode('?', input('param.offer_id'))[0];
		$offer = Db::query('select * from it_office as office join it_company as company on office.company = company.c_realname where office.offer_id='.$id)[0];
		$this->assign('offer', $offer);
		return $this->fetch();
	}

}
<?php

namespace app\index\controller;
use think\Controller;
use app\index\model\Office;
use think\Db;
<<<<<<< HEAD
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

=======
use think\Request;
use app\index\model\Company;
class Position extends Controller
{
	/**
	 * 职位搜索、显示职位页面
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	public function php(Request $request)
	{
		$offer = $request->param('offer_name');
		//双表联合查询
		$sel = Db::query("select * from it_office join it_company on it_office.company = it_company.c_realname where it_office.offer_name = '$offer'");

		if($sel) {

			$this->assign('sel',$sel);

			return $this->fetch();

		} else {

			$this->error('您搜索的内容不存在,要不再试试别的关键词');
		}
		
	}

	/**
	 * 公司主页
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	public function companyHomePage(Request $request)
	{
		$cid = $request->param('cid');
		//查询公司表获取数据
		$info = Company::get($cid)->toArray();

		$this->assign('info',$info);
		//查询职位表获取数据
		$info1 = Office::get(['company'=>$info['c_realname']])->toArray();

		$this->assign('info1',$info1);

		$position = Office::where(['company'=>$info['c_realname']])->select();

		$count = count($position);

		$this->assign('count',$count);

		return $this->fetch();
	}

	/**
	 * 显示公司正在招聘的职位的页面
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	public function requirePosition(Request $request)
	{
		$cid = $request->param('cid');
		//查询公司表获取数据
		$info = Company::get($cid)->toArray();

		$this->assign('info',$info);
		//查询职位表获取数据
		$info1 = Office::get(['company'=>$info['c_realname']])->toArray();

		$this->assign('info1',$info1);

		$position = Office::where(['company'=>$info['c_realname']])->select();
		//发布职位的个数
		$count = count($position);

		$this->assign('count',$count);

		$this->assign('position',$position);

		return $this->fetch();
	}
>>>>>>> f49e4ce7dcc47c0d39e159912e462c27af195124
}
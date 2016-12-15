<?php

namespace app\index\controller;
use think\Controller;
use app\index\model\Office;
use think\Db;
use think\Request;
use app\index\model\Company;
use app\index\model\Evaluate;
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

		$evaluate = Db::query('select * from it_evaluate join it_user on it_evaluate.uid = it_user.uid where it_evaluate.cid ='. $cid);

		$this->assign('evaluate',$evaluate);

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

	//职位详情
	public function details()
	{
		$id = explode('?', input('param.offer_id'))[0];
		$offer = Db::query('select * from it_office as office join it_company as company on office.company = company.c_realname where office.offer_id='.$id)[0];
		$this->assign('offer', $offer);
		return $this->fetch();
	}

	//公司评价
	public function comment(Request $request)
	{
		$cid = $request->param('cid');
		$data = [

			'uid'=>$request->param('uid'),

			'cid'=>$cid,

			'content'=>$request->param('evaluate')

		];

		$insert = Evaluate::create($data);

		if($insert){
			$this->success('评价成功',url('index/position/companyHomePage','cid='.$cid));
		} else {
			$this->error('评价失败');
		}
	}

	//删除评价
	public function delete(Request $request)
	{
		$eid = $request->param('eid');

		$cid = $request->param('cid');

		$del = Evaluate::destroy($eid);

		if($del) {

			$this->success('删除成功',url('index/position/companyHomePage','cid='.$cid));

		} else {

			$this->error('删除失败');
			
		}
	}
}
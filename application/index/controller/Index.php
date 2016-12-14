<?php
namespace app\index\controller;
use think\Controller;
use app\index\model\Position;
use app\index\model\Industry;
use app\index\model\Link;
use app\index\model\Office;
use app\index\model\Company;

class Index extends Controller
{
    public function index()
    {
    	//行业版块
		$big = Industry::where('parentid',0)->select();
		//职位类别版块
		$small = Industry::where('parentid', '<>', 0)->select();
		//热门职位
		$hot = Position::where('is_hot',1)->select();
		//所有职位
		$position = Position::select();
		//友情链接
		$link = Link::order('show_order','asc')->select();
		//热门工作职位
		$office = Office::where('is_hot',1)->paginate(5);
		//最新工作职位
		$new = Office::order('create_time', 'desc')->paginate(5);
		//页面主体热门公司
		$company = Company::limit(5)->select();

		$this->assign([
			'link' => $link,
			'office' => $office,
			'new' => $new,
			'big' => $big,
			'small' => $small,
			'hot' =>$hot,
			'position' => $position,
			'company' => $company
			]);
        return $this->fetch();
    }
}

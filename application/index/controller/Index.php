<?php
namespace app\index\controller;
use think\Controller;
use app\index\model\Position;
use app\index\model\Industry;
use app\index\model\Link;
use app\index\model\Office;

class Index extends Controller
{
    public function index()
    {
    	/*$info = User::get(session('uid'))->toArray();
		//dump($info1);die();
		$this->assign('info',$info);*/
		$big = Industry::where('parentid',0)->select();
		$small = Industry::where('parentid', '<>', 0)->select();
		$hot = Position::where('is_hot',1)->select();
		$position = Position::select();
		
		$link = Link::order('show_order','asc')->select();
		$office = Office::where('is_hot',1)->limit(15)->select();
		$new = Office::limit(15)->order('create_time', 'desc')->select();

		$this->assign([
			'link' => $link,
			'office' => $office,
			'new' => $new,
			'big' => $big,
			'small' => $small,
			'hot' =>$hot,
			'position' => $position
			]);
        return $this->fetch();
    }
}

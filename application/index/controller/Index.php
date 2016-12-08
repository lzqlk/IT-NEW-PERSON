<?php
namespace app\index\controller;
use think\Controller;
use app\index\model\User;
use app\index\model\Company;
use app\index\model\Resume;
class Index extends Controller
{
    public function index()
    {
    	/*$info = User::get(session('uid'))->toArray();
		//dump($info1);die();
		$this->assign('info',$info);*/
        return $this->fetch();
    }
}

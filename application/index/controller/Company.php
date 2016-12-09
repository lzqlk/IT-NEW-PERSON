<?php

namespace app\index\controller;
use app\index\controller\Auth;
use think\Request;
class Company extends Auth
{
	public function verify()
	{
		
		return $this->fetch();
	}

	public function doVerify(Request $request)
	{
		dump($request);
	}
}
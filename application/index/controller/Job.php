<?php

namespace app\index\controller;
use think\Controller;
class Job extends Controller
{
	public function php()
	{
		return $this->fetch();
	}
}
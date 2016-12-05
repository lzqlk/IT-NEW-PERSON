<?php

namespace app\index\controller;
use app\index\controller\Auth;
class Company extends Auth
{
	public function profile()
	{
		return $this->fetch();
	}
}
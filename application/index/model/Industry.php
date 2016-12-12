<?php
namespace app\index\model;
use think\Model;

class Industry extends Model
{
	public function position()
	{
		return $this->hasMany('Position', 'iid', 'iid');
	}
}

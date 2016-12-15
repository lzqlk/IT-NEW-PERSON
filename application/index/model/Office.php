<?php

namespace app\index\model;
use think\Model;

class Office extends Model
{
	public function company()
	{
		$this->belongsTo('Company', 'c_realname', 'offer_id');
	}
}
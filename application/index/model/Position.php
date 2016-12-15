<?php
namespace app\index\model;
use think\Model;

class Position extends Model
{
	public function industry()
	{
		$this->belongsTo('Industry', 'iid', 'pid');
	}
}
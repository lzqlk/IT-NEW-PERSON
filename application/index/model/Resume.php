<?php	
namespace app\index\model;
use think\Model;

class Resume extends Model
{
	public function user()
	{
		return $this->belongsTo('User','uid');
	}
}
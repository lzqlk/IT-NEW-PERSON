<?php
/**
 * 职位管理模型
 */
namespace app\admin\model;
use think\Model;
use traits\model\SoftDelete;
class Office extends Model
{
	use SoftDelete;
	protected $deleteTime = 'delete_time';

	public function send()
	{
		return $this->hasMany('Send', 'offer_id');
	}
}
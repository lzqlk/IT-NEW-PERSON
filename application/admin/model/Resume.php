<?php
/**
 * 简历管理模型
 */
namespace app\admin\model;
use think\Model;
use traits\model\SoftDelete;
class Resume extends Model
{
	use SoftDelete;
	protected $deleteTime = 'delete_time';

	public function user()
	{
		return $this->belongsTo('User', 'uid');
	}
}
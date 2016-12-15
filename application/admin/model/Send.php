<?php
/**
 * 简历投递管理模型
 */
namespace app\admin\model;
use think\Model;
use traits\model\SoftDelete;
class Send extends Model
{
	use SoftDelete;
	protected $deleteTime = 'delete_time';
}
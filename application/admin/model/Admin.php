<?php
/**
 * 管理员信息模型
 */
namespace app\admin\model;
use think\Model;
use traits\model\SoftDelete;
class Admin extends Model
{	
	use SoftDelete;
	protected $deleteTime = 'delete_time';
}
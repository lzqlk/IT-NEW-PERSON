<?php
/**
 * 求职用户管理模型
 */
namespace app\admin\model;
use think\Model;
use traits\model\SoftDelete;
class User extends Model
{
	use SoftDelete;
	protected $deleteTime = 'delete_time';
}
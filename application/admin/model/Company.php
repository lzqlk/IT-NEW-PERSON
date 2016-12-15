<?php
/**
 * 企业用户模型
 */
namespace app\admin\model;
use think\Model;
use traits\model\SoftDelete;
class Company extends Model
{
	use SoftDelete;
	protected $deleteTime = 'delete_time';
}
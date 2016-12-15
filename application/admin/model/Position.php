<?php
/**
 * 职位分类模型
 */
namespace app\admin\model;
use think\Model;
use traits\model\SoftDelete;
class Position extends Model
{
	use SoftDelete;
	protected $deleteTime = 'delete_time';
}
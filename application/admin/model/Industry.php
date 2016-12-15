<?php
/**
 * 行业分类管理模型
 */
namespace app\admin\model;
use think\Model;
use traits\model\SoftDelete;
class Industry extends Model
{
	use SoftDelete;
	protected $deleteTime = 'delete_time';
}
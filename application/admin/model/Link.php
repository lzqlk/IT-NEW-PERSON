<?php
/**
 * 友情链接管理模型
 */
namespace app\admin\model;
use think\Model;
use traits\model\SoftDelete;
class Link extends Model
{
	use SoftDelete;
	protected $deleteTime = 'delete_time';
}
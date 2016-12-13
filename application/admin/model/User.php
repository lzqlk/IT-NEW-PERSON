<?php
namespace app\admin\model;
use think\Model;
use traits\model\SoftDelete;
class User extends Model
{
	use SoftDelete;
	protected $deleteTime = 'delete_time';

	/*public function resume()
	{
		return $this->hasOne('Resume', 'uid');
	}*/
}
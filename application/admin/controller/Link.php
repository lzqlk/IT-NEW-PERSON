<?php
namespace app\admin\controller;
use think\Controller;
use app\admin\model\Link;
use think\Db;
class Link extends Auth
{
	public function link()
	{
		$list = Link::paginate(10);
		$soft = Link::onlyTrashed()->paginate(10);
		$this->assign('list', $list);
		$this->assign('soft',$soft);
		return $this->fetch();
	}

	public function add()
	{
		Link::create([
				'show_order' => input('param.show_order'),
				'site_name' => input('param.web_name'),
				'url' => input('param.url'),
				'logo' => input('param.logo'),
				'description' => input('param.describe')
			]);
		$this->redirect('admin/link/link');
	}

	public function delete()
	{
		Link::destroy(input('param.lid'));
		$this->redirect('admin/link/link');
	}

	public function renew(Link $link)
	{
		Db::name('link')->where('lid', input('param.lid'))->update(['delete_time' => NULL]);
		$this->redirect('admin/link/link');
	}

	public function reldelete()
	{
		Db::name('link')->where('lid', input('param.lid'))->delete();
		$this->redirect('admin/link/link');
	}
}
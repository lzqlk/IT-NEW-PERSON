<?php
namespace app\admin\controller;
use think\Controller;
use app\admin\model\Link as Li;
use think\Db;
class Link extends Auth
{
	//友情链接页面
	public function link()
	{
		$list = Li::paginate(10);
		$soft = Li::onlyTrashed()->paginate(10);
		$this->assign('list', $list);
		$this->assign('soft',$soft);
		return $this->fetch();
	}
	//添加友情链接
	public function add()
	{
		Li::create([
				'show_order' => input('param.show_order'),
				'site_name' => input('param.web_name'),
				'url' => input('param.url'),
				'logo' => input('param.logo'),
				'description' => input('param.describe')
			]);
		$this->redirect('admin/link/link');
	}
	//软删除友情链接
	public function delete()
	{

		Li::destroy(input('param.lid/a'));

		$this->redirect('admin/link/link');
	}
	//恢复回收站里的数据
	public function renew()
	{
		Db::name('link')->where('lid', input('param.lid'))->update(['delete_time' => NULL]);
		$this->redirect('admin/link/link');
	}
	//彻底删除回收站里的数据
	public function reldelete()
	{
		Db::name('link')->where('lid', input('param.lid'))->delete();
		$this->redirect('admin/link/link');
	}

	//对回收站里的数据进行操作
	public function action()
	{
		if (input('param.btn')) {
			//彻底删除简历回收站里的数据
			Db::name('link')->where('lid', 'in', input('param.lid/a'))->delete();
		} else {
			//恢复简历回收站里的数据
			Db::name('link')->where('lid', 'in', input('param.lid/a'))->update(['delete_time' => NULL]);
		}
		$this->redirect('admin/link/link');
	}
}
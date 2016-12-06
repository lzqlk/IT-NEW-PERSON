<?php
namespace app\index\controller;
use app\index\controller\Auth;
use think\Request;
use app\index\model\User;

class User extends Auth
{
	public function userInfo()
	{
		$info = User::get(session('uid'))->toArray();
		//dump($info);die();
		$this->assign('info',$info);
		return $this->fetch();
	}
	/**
	 * 修改个人信息
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	public function update_info(Request $request)
	{
		
			$file = request()->file('photo');
			if($file) {
				$photo = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
				
				if($photo){
					$photo1 = '__SITE__/uploads/'.$photo->getSaveName();
					/*echo $info->getFilename();die();*/
				} else {
					$this->error($file->getError());
				}
			} else {
				$photo1 = session('photo');
			}
			
		$user = new User;

		$user->save([
			'username'=>$request->param('username'),
			'sex'=>$request->param('sex'),
			'profession'=>$request->param('profession'),
			'self'=>$request->param('self'),
			'photo'=>$photo1,
			'update_time'=>time()
			],['uid'=>session('uid')]);
		session('photo',$photo1);
		$this->redirect('index/user/userInfo');
	}
}
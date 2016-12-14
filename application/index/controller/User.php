<?php
namespace app\index\controller;
use app\index\controller\Auth;
use think\Request;
use app\index\model\User;
use app\index\model\Company;
use app\index\model\Resume;
class User extends Auth
{
	//用户信息页
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
		$user = new User;
		//dump($request);die();
		
		//获取头像路径并验证
		$file = request()->file('photo');
		
		if($file) {
			$photo = $file->move(ROOT_PATH . 'public' . DS . 'uploads');

			if($photo){
				$photo1 = '__SITE__/uploads/'.$photo->getSaveName();
			} else {
				$this->error($file->getError());
			}
		} else {
			$photo1 = session('photo');
		}

		//验证手机号
		
		$phone = $request->param('phone_num');
		
		$pattern = "/^1(3|4|5|7|8)\d{9}$/";
		
		if($phone != '') {
			if (!preg_match($pattern, $phone,$match)) {
				$this->error('手机号错误');
			}
		}
		
		//验证邮箱
		$email = $request->param('email');

		$pattern1 = "/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/";
		
		if($email != '') {

			if (!preg_match($pattern1, $email,$match1)) {

				$this->error('邮箱格式错误');

			}
		}
		
		//链接数据库 更新数据库
		$user->save([

			'username'=>$request->param('username'),

			'sex'=>$request->param('sex'),

			'phone_num'=>$phone,

			'email'=>$email,

			'profession'=>$request->param('profession'),

			'self'=>$request->param('self'),

			'photo'=>$photo1,

			'update_time'=>time()

			],['uid'=>session('uid')]);

		session('photo',$photo1);

		session('username',$request->param('username'));

		$this->success('保存成功');
	}

	//修改密码页
	public function updatePwd()
	{
		$info = User::get(session('uid'))->toArray();
		
		$this->assign('info',$info);

		return $this->fetch();
	}

	//修改密码
	public function update_pwd(Request $request)
	{
		$user = new User;
		
		$sel = User::get(['uid'=>session('uid')])->toArray();
		
		$oldPwd = md5($request->param('oldpassword'));

		$newPwd = $request->param('newpassword');

		$comfirmPwd = $request->param('comfirmpassword');

		if ($oldPwd != $sel['password']) {

			$this->error('密码错误');

		}
		if($newPwd != $comfirmPwd) {

			$this->error('两次密码不相等');

		}

		$user->save([

			'password'=>md5($newPwd)

			],['uid'=>session('uid')]);

		$this->success('修改成功,请重新登录','index/auth/login', '', 1);
	}

	//处理ajax请求，实现局部刷新
	public function checkPwd(Request $request)
	{

		$sel = User::get(['uid'=>session('uid')])->toArray();

		$pwd = md5($request->param('password'));

		if($sel['password'] == $pwd) {

			echo json_encode(array('status' => 1, 'msg' => '正确'));

		} else {

			echo json_encode(array('status' => 0));

		}
	}


	//创建简历第一步
	public function resume()
	{
		$info = User::get(session('uid'))->toArray();
		
		$this->assign('info',$info);

		return $this->fetch();
	}

	//获取输入数据，插入数据库
	public function doresume(Request $request)
	{
		
		$uid = session('uid');

		$realname = $request->param('realname');

		$edu = $request->param('topDegree');

		$worklife = $request->param('wokrYear');

		$phone = $request->param('phone_num');

		$email = $request->param('email');

		$city = $request->param('workCity');

		if(!$realname) {

			$this->error('姓名不能为空');

		}
		$data = [

			'uid'=>$uid,

			'realname'=>$realname,

			'education'=>$edu,

			'worklife'=>$worklife,

			'phone_num'=>$phone,

			'email'=>$email,

			'city'=>$city,

			'create_time'=>time()
		];

		$insert = Resume::create($data);

		$sel = Resume::get(['uid'=> $uid]);

		if($insert) {

			session('rid',$sel['rid']);

			$this->redirect('index/user/experience');
		}
	}

	//创建简历第二步，填写工作经验
	public function experience()
	{
		$info = User::get(session('uid'))->toArray();
		
		$this->assign('info',$info);

		return $this->fetch();
	}

	//链接数据库并更新
	public function doExperience(Request $request)
	{
		$resume = new Resume;
		
		$resume->save([

			'c_name'=>$request->param('companyName'),

			'position'=>$request->param('yourPosition'),

			'start_time'=>$request->param('startTime'),

			'end_time'=>$request->param('endTime')

			],['rid'=>session('rid')]);

		if($resume) {

			$this->redirect('index/user/education');
		}

	}

	//创建简历第三步，填写教育经历
	public function education()
	{
		$info = User::get(session('uid'))->toArray();
		
		$this->assign('info',$info);

		return $this->fetch();
	}

	//链接数据库并更新
	public function doEducation(Request $request)
	{
		$resume = new Resume;
		
		$resume->save([

			'school'=>$request->param('schoolName'),

			'major'=>$request->param('yourMajor'),

			'education'=>$request->param('degree'),

			'school_end'=>$request->param('schoolEnd')

			],['rid'=>session('rid')]);

		if($resume) {

			$this->redirect('index/user/introduce');

		}
	}

	//创建简历第四步,一句话介绍自己
	public function introduce()
	{

		$info = User::get(session('uid'))->toArray();

		$info1 = Resume::get(session('rid'))->toArray();
		
		$this->assign('info',$info);

		$this->assign('info1',$info1);

		return $this->fetch();
	}

	//连接数据库并更新
	public function doIntroduce(Request $request)
	{
		$resume = new Resume;

		$user = new User;

		$self = $request->param('self');

		if($self == '') {

			$this->error('先介绍你自己');

		}
		$resume->save([

			'introduce'=>$self

			],['rid'=>session('rid')]);

		$user->save([

			'resume'=>1

			],['uid'=>session('uid')]);

		session('resume',1);

		if($resume) {

			$this->redirect('index/user/myResume');
		}
	}

	//显示我的简历页
	public function myResume()
	{

		$info = User::get(session('uid'))->toArray();

		$info1 = Resume::where('uid',session('uid'))->find();

		$update_time = date('Y-m-d H:m',$info1['update_time']);
		
		$this->assign('info',$info);

		$this->assign('info1',$info1);

		$this->assign('update_time',$update_time);
		
		return $this->fetch();
	}
}
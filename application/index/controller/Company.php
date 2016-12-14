<?php

namespace app\index\controller;
use app\index\controller\Auth;
use think\Request;
use app\index\model\User;
use app\index\model\Company;
use app\index\model\Resume;
use app\index\model\Office;
use think\Db;
class Company extends Auth
{
	public function verify()
	{
		
		return $this->fetch();
	}

	//验证企业邮箱
	public function doVerify(Request $request)
	{
		$company = new Company;
		//dump($request);die();
		$subject="测试";
		
		$email=$request->param('cemail');
		$call = $request->param('call_num');

		/*$con = '<style class="fox_global_style"> div.fox_html_content { line-height: 1.5;} /* 一些默认样式  blockquote { margin-Top: 0px; margin-Bottom: 0px; margin-Left: 0.5em } ol, ul { margin-Top: 0px; margin-Bottom: 0px; list-style-position: inside; } p { margin-Top: 0px; margin-Bottom: 0px } </style><table style="-webkit-font-smoothing: antialiased;font-family:"微软雅黑", "Helvetica Neue", sans-serif, SimHei;padding:35px 50px;margin: 25px auto; background:rgb(247,246, 242); border-radius:5px" border="0" cellspacing="0" cellpadding="0" width="640" align="center"> <tbody> <tr> <td style="color:#000;"> </td> </tr> <tr><td style="padding:0 20px"><hr style="border:none;border-top:1px solid #ccc;"></td></tr> <tr> <td style="padding: 20px 20px 20px 20px;"> Hi 你好 </td> </tr> <tr> <td valign="middle" style="line-height:24px;padding: 15px 20px;"> 感谢您注册IT精英网 <br> 请点击以下链接开启您的招才之旅： </td> </tr> <tr> <td style="height: 50px;color: white;" valign="middle"> <div style="padding:10px 20px;border-radius:5px;background: rgb(64, 69, 77);margin-left:20px;margin-right:20px"> <a style="word-break:break-all;line-height:23px;color:white;font-size:15px;text-decoration:none;" href="http://www.itnewperson.com/index/company/release">http://www.itnewperson.com</a> </div> </td> </tr> <tr> <td style="padding: 20px 20px 20px 20px"> 请勿回复此邮件，如果有疑问，请联系我们：<a style="color:#5083c0;text-decoration:none" href="mailto:liu123@loveforyoung.cn">liu123@loveforyoung.cn
	</a> </td> </tr><tr> <td style="padding: 20px 20px 20px 20px"> 交流群：000000 </td> </tr> <tr> <td style="padding: 20px 20px 20px 20px"> - phpbryant 团队-帮助你更快的完成项目- phpbryant.com </td> </tr> </tbody> </table>';*/
		$company->save([
			'call_num'=>$request->param('call_num'),
			'cemail'=>$request->param('cemail')
			
			],['cid'=>session('cid')]);
		$this->success('开通成功,请完善公司信息','index/company/companyInfo');
		/*$status = send($email,$subject,$con);
		if($status){
			$this->redirect('index/company/companyInfo');
		}else{
			$this->error('邮箱格式不正确');
		}*/
	}

	public function companyInfo()
	{
		$info = Company::get(session('cid'))->toArray();
		//dump($info);die();
		$this->assign('info',$info);
		return $this->fetch();
	}

	public function update_info(Request $request)
	{
		$company = new Company;
		//dump($request);die();
		
		//获取头像路径并验证
		$file = request()->file('logo');
		
		if($file) {
			$logo = $file->move(ROOT_PATH . 'public' . DS . 'uploads');

			if($logo){
				$logo1 = '__SITE__/uploads/'.$logo->getSaveName();
			} else {
				$this->error($file->getError());
			}
		} else {
			$logo1 = session('logo');
		}

		//验证手机号
		
		$call = $request->param('call_num');
		//dump($phone);die();
		$pattern = "/^1(3|4|5|7|8)\d{9}$/";
		/*$sel = User::get(['phone_num'=> $phone]);
		if($sel) {
			$this->error('该号码已被注册');
		}*/
		if($call != '') {
			if (!preg_match($pattern, $call,$match)) {
				$this->error('手机号错误');
			}
		}
		
		//验证邮箱
		$cemail = $request->param('cemail');
		$pattern1 = "/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/";
		/*$sel1 = User::get(['email'=> $email]);
		if($sel1) {
			$this->error('该邮箱已被注册');
		}*/
		if($cemail != '') {
			if (!preg_match($pattern1, $cemail,$match1)) {
				$this->error('邮箱格式错误');
			}
		}
		
		//链接数据库 更新数据库
		$company->save([
			'c_realname'=>$request->param('c_realname'),
			'call_num'=>$call,
			'cemail'=>$cemail,
			'c_introduce'=>$request->param('c_introduce'),
			'logo'=>$logo1,
			'city'=>$request->param('city'),
			'scale'=>$request->param('scale'),
			'slogan'=>$request->param('slogan'),
			'update_time'=>time()
			],['cid'=>session('cid')]);
		session('logo',$logo1);
		session('c_realname',$request->param('c_realname'));
		$this->success('保存成功,赶快去发布职位吧','index/company/release');
	}

	public function release()
	{
		$info = Company::get(session('cid'))->toArray();
		//dump($info);die();
		$this->assign('info',$info);
		return $this->fetch();
	}

	public function doRelease(Request $request)
	{
		//dump($request);
		$data = [
			'positionType'=>$request->param('positionType'),
			'offer_name'=>$request->param('positionName'),
			'company'=>session('c_realname'),
			'money'=>$request->param('salaryMin').'k',
			'experience'=>$request->param('workYear'),
			'education'=>$request->param('education'),
			'financing'=>$request->param('financing'),
			'industry'=>$request->param('industry'),
			'positionAdvantage'=>$request->param('positionAdvantage'),
			'description'=>$request->param('positionDetail'),
			'positionAddress'=>$request->param('positionAddress')
		];

		$insert = Office::create($data);
		if($insert) {
			$this->success('发布成功');
		} else {
			$this->error('发布失败');
		}
	}

	public function companyHomePage()
	{
		$info = Company::get(session('cid'))->toArray();
		$this->assign('info',$info);
		$info1 = Office::get(['company'=>session('c_realname')])->toArray();
		$this->assign('info1',$info1);
		$position = Office::where(['company'=>session('c_realname')])->select();
		$count = count($position);
		$this->assign('count',$count);
		return $this->fetch();
	}

	public function requirePosition()
	{
		$info = Company::get(session('cid'))->toArray();
		$this->assign('info',$info);
		$info1 = Office::get(['company'=>session('c_realname')])->toArray();
		$this->assign('info1',$info1);
		$position = Office::where(['company'=>session('c_realname')])->select();
		$count = count($position);
		$this->assign('count',$count);
		$this->assign('position',$position);
		return $this->fetch();
	}

	public function resume()
	{
		$company = Db::query('select * from it_company as c join it_office as o on c.c_realname=o.company join it_send as s on o.offer_id=s.offer_id join it_resume as r on s.user_id=r.uid where cid='.session('cid'));
		$this->assign('company', $company);
		return $this->fetch();
	}

	public function details()
	{
		$detail = Resume::find(input('param.rid'));
		$this->assign('detail', $detail);
		return $this->fetch();
	}
}
<?php

namespace app\index\controller;
use think\Controller;
use think\Request;
use think\Db;
use app\index\model\User;
use app\index\model\Company;
use app\index\model\Resume;
use app\index\model\Office;
<<<<<<< HEAD
use think\Db;
class Company extends Auth
=======
class Company extends Controller
>>>>>>> f49e4ce7dcc47c0d39e159912e462c27af195124
{
	//企业验证页面
	public function verify()
	{
		
		return $this->fetch();

	}

	//验证企业邮箱
	public function doVerify(Request $request)
	{
		$cid = $request->param('cid');

		$company = new Company;

		//dump($request);die();
		$company->save([

			'call_num'=>$request->param('call_num'),

			'cemail'=>$request->param('cemail')
			
			],['cid'=>$cid]);

		$subject="测试";
		
		$email=$request->param('cemail');

		$con = '<style class="fox_global_style"> div.fox_html_content { line-height: 1.5;} /* 一些默认样式 */ blockquote { margin-Top: 0px; margin-Bottom: 0px; margin-Left: 0.5em } ol, ul { margin-Top: 0px; margin-Bottom: 0px; list-style-position: inside; } p { margin-Top: 0px; margin-Bottom: 0px } </style><table style="-webkit-font-smoothing: antialiased;font-family:"微软雅黑", "Helvetica Neue", sans-serif, SimHei;padding:35px 50px;margin: 25px auto; background:rgb(247,246, 242); border-radius:5px" border="0" cellspacing="0" cellpadding="0" width="640" align="center"> <tbody> <tr> <td style="color:#000;"> </td> </tr> <tr><td style="padding:0 20px"><hr style="border:none;border-top:1px solid #ccc;"></td></tr> <tr> <td style="padding: 20px 20px 20px 20px;"> Hi 你好 </td> </tr> <tr> <td valign="middle" style="line-height:24px;padding: 15px 20px;"> 感谢您注册IT精英网 <br> 请点击以下链接开启您的招才之旅： </td> </tr> <tr> <td style="height: 50px;color: white;" valign="middle"> <div style="padding:10px 20px;border-radius:5px;background: rgb(64, 69, 77);margin-left:20px;margin-right:20px"> <a style="word-break:break-all;line-height:23px;color:white;font-size:15px;text-decoration:none;" href="http://www.itnewperson.com/index/company/companyInfo/cid/'.$cid.'">http://www.itnewperson.com</a> </div> </td> </tr> <tr> <td style="padding: 20px 20px 20px 20px"> 请勿回复此邮件，如果有疑问，请联系我们：<a style="color:#5083c0;text-decoration:none" href="mailto:liu123@loveforyoung.cn">liu123@loveforyoung.cn
	</a> </td> </tr><tr> <td style="padding: 20px 20px 20px 20px"> 交流群：000000 </td> </tr> <tr> <td style="padding: 20px 20px 20px 20px"> - phpbryant 团队-帮助你更快的完成项目- phpbryant.com </td> </tr> </tbody> </table>';
		
		
		$status = send($email,$subject,$con);

		if($status){

			$this->success('您已成功开通招聘服务，请登录邮箱完善信息后再发布职位');

		}else{

			$this->error('邮箱格式不正确');

		}
	}

	/**
	 * 完善公司信息页
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	public function companyInfo(Request $request)
	{
		$cid = $request->param('cid');

		$info = Company::get($cid)->toArray();

		session('cid',$info['cid']);
		
		$this->assign('info',$info);

		return $this->fetch();
	}

	/**
	 * 更新企业信息
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	public function update_info(Request $request)
	{
		$company = new Company;
		
		$cid = $request->param('cid');
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
		
		$pattern = "/^1(3|4|5|7|8)\d{9}$/";
		
		if($call != '') {

			if (!preg_match($pattern, $call,$match)) {
				$this->error('手机号错误');
			}
		}
		
		//验证邮箱
		$cemail = $request->param('cemail');

		$pattern1 = "/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/";
	
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
			],['cid'=>$cid]);
		session('logo',$logo1);
		session('c_realname',$request->param('c_realname'));
		$this->success('保存成功,赶快去发布职位吧',url("__SITE__/index/company/release","cid=$cid"));
	}

	/**
	 * 发布职位页面
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	public function release(Request $request)
	{
		$cid = $request->param('cid');

		$info = Company::get($cid)->toArray();

		session('username',$info['cname']);

		$this->assign('info',$info);

		return $this->fetch();
	}

	/**
	 * 填写职位需求信息
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	public function doRelease(Request $request)
	{
		
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

	public function company_list()
	{
		$sel = Company::where('cid', '>', 0)->select();
		$this->assign('sel',$sel);
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
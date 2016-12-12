<?php

namespace app\index\controller;
use app\index\controller\Auth;
use think\Request;
class Company extends Auth
{
	public function verify()
	{
		
		return $this->fetch();
	}

	//验证企业邮箱
	public function doVerify(Request $request)
	{
		//dump($request);
		$subject="测试";
		
		$email=$request->param('cemail');
		// $email="718041217@qq.com";

		$con = '<style class="fox_global_style"> div.fox_html_content { line-height: 1.5;} /* 一些默认样式 */ blockquote { margin-Top: 0px; margin-Bottom: 0px; margin-Left: 0.5em } ol, ul { margin-Top: 0px; margin-Bottom: 0px; list-style-position: inside; } p { margin-Top: 0px; margin-Bottom: 0px } </style><table style="-webkit-font-smoothing: antialiased;font-family:"微软雅黑", "Helvetica Neue", sans-serif, SimHei;padding:35px 50px;margin: 25px auto; background:rgb(247,246, 242); border-radius:5px" border="0" cellspacing="0" cellpadding="0" width="640" align="center"> <tbody> <tr> <td style="color:#000;"> </td> </tr> <tr><td style="padding:0 20px"><hr style="border:none;border-top:1px solid #ccc;"></td></tr> <tr> <td style="padding: 20px 20px 20px 20px;"> Hi 你好 </td> </tr> <tr> <td valign="middle" style="line-height:24px;padding: 15px 20px;"> 感谢您注册IT精英网 <br> 请点击以下链接开启您的招才之旅： </td> </tr> <tr> <td style="height: 50px;color: white;" valign="middle"> <div style="padding:10px 20px;border-radius:5px;background: rgb(64, 69, 77);margin-left:20px;margin-right:20px"> <a style="word-break:break-all;line-height:23px;color:white;font-size:15px;text-decoration:none;" href="http://www.itnewperson.com/index/company/release">http://www.itnewperson.com</a> </div> </td> </tr> <tr> <td style="padding: 20px 20px 20px 20px"> 请勿回复此邮件，如果有疑问，请联系我们：<a style="color:#5083c0;text-decoration:none" href="mailto:liu123@loveforyoung.cn">liu123@loveforyoung.cn
	</a> </td> </tr><tr> <td style="padding: 20px 20px 20px 20px"> 交流群：000000 </td> </tr> <tr> <td style="padding: 20px 20px 20px 20px"> - phpbryant 团队-帮助你更快的完成项目- phpbryant.com </td> </tr> </tbody> </table>';
		$status = send($email,$subject,$con);
		if($status){
			$this->success('登录链接已发送至您的邮箱,注意查收');
		}else{
			$this->error('邮箱格式不正确');
		}
	}

	public function release()
	{
		return $this->fetch();
	}

}
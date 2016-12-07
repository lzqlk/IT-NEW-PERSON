$(function() {

	function checkPhone() {
		var reg = /^1(3|4|5|7|8)\d{9}$/;
		//用ajax请求数据库，验证手机号是否已被注册
		/*$.post('/index/user/checkPhoneNum', {phone_num: $(".phone").val()}, function(data){
			if(data.status){

				$(".phone").next().html('<font color="red">'+ data.msg + '</font>');

			} else */
			if(reg.test($(".phone").val())) {

				$(".phone").next().html('<font color="green">正确的手机号</font>');

			return true;
			} else {
				
				$(".phone").next().html('<font color="red">请输入正确的手机号</font>');
			return false;
			}
	/*	}, 'json');*/

	
	}
	/**
	 * 用ajax和正则配合伪验证用户输入的密码是否符合要求
	 * @return {[type]} [description]
	 */
	function checkEmail() {

		var reg = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

		if (reg.test($(".email").val())) {
			$(".email").next().html('<font color="green">正确的邮箱</font>');
			return true;
		} else {
			$(".email").next().html('<font color="red">邮箱格式不正确</font>');
			return false;
		}
	}

	function checkPassword()
	{
		
		$.post('/index/user/checkPwd', {password: $("#oldpassword").val()}, function(data){
			if(data.status){

				$("#oldpassword").next().html('<font color="green">'+ data.msg + '</font>');
			} else {
				$("#oldpassword").next().html('<font color="red">密码错误</font>');
			}
		}, 'json');

		
	}

	function checkNewPwd()
	{
		var reg = /\S{6,18}/;

		if (reg.test($("#newpassword").val())) {
			$("#newpassword").next().html('<font color="green">符合</font>');
			return true;
		} else {
			$("#newpassword").next().html('<font color="red">格式错误</font>');
			return false;
		}
	}

	function checkComfirmPwd()
	{
		var a = $("#newpassword").val();

		if($("#comfirmpassword").val() != a) {
			$("#comfirmpassword").next().html('<font color="red">驴唇马嘴</font>');
			return false;
		} else {
			$("#comfirmpassword").next().html('<font color="green">符合</font>');
			return true;
		}
	}

	$(".phone").blur(function() {

		checkPhone();
	});

	$(".email").blur(function() {
		checkEmail();
	});

	$("#oldpassword").blur(function() {
		checkPassword();
	});

	$("#newpassword").blur(function() {
		checkNewPwd();
	});

	$("#comfirmpassword").blur(function() {
		checkComfirmPwd();
	});


});

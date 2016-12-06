$(function() {

	function checkUsername() {
		var reg = /^[a-zA-Z0-9\u4e00-\u9fa5]{2,18}/;
		//用ajax请求数据库，验证用户名是否已被注册
		$.post('/index/auth/checkName', {username: $("#username").val()}, function(data){
			if(data.status){

				$("#username").next().html('<font color="red">'+ data.msg + '</font>');

			} else if(reg.test($("#username").val())) {

				$("#username").next().html('<font color="green">合法的用户名</font>');

			return true;
			} else {
				
				$("#username").next().html('<font color="red">用户名必须是2~18位汉字或字母或数字</font>');
			return false;
			}
		}, 'json');

	
	}
	/**
	 * 用ajax和正则配合伪验证用户输入的密码是否符合要求
	 * @return {[type]} [description]
	 */
	function checkPassword() {

		var reg = /\S{6,18}/;

		if (reg.test($("#password").val())) {
			$("#password").next().html('<font color="green">合法的密码</font>');
			return true;
		} else {
			$("#password").next().html('<font color="red">密码必须是6-18位的字符</font>');
			return false;
		}
	}

	$("#username").blur(function() {

		checkUsername();
	});

	$("#password").blur(function() {
		checkPassword();
	});


});

$(function() {

	function checkUsername() {
		var reg = /^[a-zA-Z0-9\u4e00-\u9fa5]{2,18}/;

		if (reg.test($("#username").val())) {
			$("#username").next().html('<font color="green">合法的用户名</font>');
			return true;
		} else {
			$("#username").next().html('<font color="red">用户名必须是2~18位汉字或字母或数字</font>');
			return false;
		}
	}

	function checkPassword() {
		var reg = /\S{6,18}/;

		if (reg.test($("#password").val())) {
			$("#password").next().html('<font color="green">合法的密码</font>');
			return true;
		} else {
			$("#password").next().html('<font color="red">密码必须是6-18s位的字符</font>');
			return false;
		}
	}

	$("#username").blur(function() {

		checkUsername();
	});

	$("#password").blur(function() {
		checkPassword();
	});

	$("#sub").click(function() {
		if (checkUsername() && checkPassword()) {
			$.post('http://localhost/code/1603/1122/rex/user.php', {username: $("#username").val(), password: $("#password").val()}, function(data){
				if(data.status){
					alert(data.msg);
					setTimeout(function(){
						location.href = 'http://baidu.com';
					}, 3000);
				}else{
					alert(data.msg);
				}
			}, 'json');
			return false;
		} else {
			return false;
		}
	});

});
 function check(){
	      var uname=document.form1.uname.value;
		  var pwd=document.form1.pwd.value;
		  var pattern=/^[\u4e00-\u9fa5]+$/;
		  var pattern1=/\d+/;
		  
		  if(!pattern.test(uname)){
			    alert("姓名必须为中文，请输入中文！！！");
			  }
		  if(!pattern1.test(pwd)){
			  alert("密码必须为数字！！！");
			  }
		  
	   }

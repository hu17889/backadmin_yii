<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>登录页</title>
<link href="/css/css.css" rel="stylesheet" media="screen" type="text/css" />.
<link rel="stylesheet" href="/css/jqtransform.css" type="text/css" media="all" />
<script type="text/javascript" src="/js/jquery171.js" ></script>
<script >
function slay2(num)
{
	for(var id = 1;id<=2;id++)
	{
		var ss="logintabcont"+id; 
	
		if(id==num)
			document.getElementById(ss).style.display="block";
		else
			document.getElementById(ss).style.display="none";
	}  

	for(var id = 1;id<=2;id++)
	{
	
		var bb="logintab"+id;
	
		if(id==num)
			document.getElementById(bb).className="active";
		else
			document.getElementById(bb).className="";
	}
}

</script>

</head>

<body class="register_bg">
<div class="content">
	<div class="register_logo"><img src="/images/frame/register_logo.png" /></div>
    <DIV class="register">
        <UL>
            <LI class="active" id="logintab1"><A onclick=javascript:slay2(1) href="javascript:slay2(1)"><img src="/images/frame/register_logo_1.png" /></A></LI>
            <LI id="logintab2"><A onclick=javascript:slay2(2) href="javascript:slay2(2)"><img src="/images/frame/register_logo_2.png" /></A></LI>
        </UL>
    </DIV>
    <DIV id="logintabcont1">
    	<div class="ml300">
            <form action="/main/user/login" method="post">
            <?php if(!empty($error)) {?><span class='red_tip'>用户名密码错误</span><?php }?>
            <p><input name="name" type="text" size="33"  class="input1"/></p>
                 <p><input name="pwd" type="password" size="33"  class="input2"/></p>
                 <input name="url" type="hidden" value="<?php echo $url;?>"/>
                 <p><input name="login_sub" type="submit"  class="submit2" value="&nbsp;&nbsp;" /></p>
            </form>
        </div>
    </DIV>
    <DIV id="logintabcont2" style="DISPLAY: none;height:400px">
    	<div class="ml300">
        	<form action="/main/user/register" method="post" onsubmit="return false;">
                 <p><input id="regname" name="name" type="text" size="33"  class="input1" /><span>*</span></p>
                 <p id="accounterror" style="display:none"><span style="font-size:10px"></span></p>
                 <p><input id="regpwd" name="pwd" type="password" size="33"  class="input3" /><span>*</span></p>
                 <p><input id="regpwdconfirm" name="pwdconfirm" type="password" size="33"  class="input4" /><span>*</span></p>
				 <p id="pwderror" style="display:none"><span style="font-size:10px"></span></p>
                 <p><input id="regemail" name="email" type="text" size="33"  class="input5" /><span>*</span></p>
                 <p id="emailerror" style="display:none"><span style="font-size:10px"></span></p>
                 <p><input type="button"  id="registerid" class="submit1" value="&nbsp;&nbsp;" /></p>
            </form>
        </div>
    </DIV>
    
    </DIV>
    <div class="Copyright">Copyright© 2012 Open Vision. 版权所有</div>
</div>
<script type="text/javascript">
$("#registerid").click(function(){
	$('#accounterror').css('display','none');
	$('#pwderror').css('display','none');
	$('#emailerror').css('display','none');
	var name=$('#regname').val();
	var pwd=$('#regpwd').val();
	var pwdconfirm=$('#regpwdconfirm').val();
	var email=$('#regemail').val();
      if(pwd != pwdconfirm)
      {
	$('#pwderror span').html('两次密码不一致');
	$('#pwderror').css('display','block');
	return false;
      }
	$.ajax({
		type : 'post',
		data : 'name=' + name + '&pwd=' + pwd + '&pwdconfirm=' + pwdconfirm + '&email=' + email,
		dataType : 'json',
		url : '/main/user/register',
		success: function(data)
		{
			if(data.retCode == 0)
			{
				location.href="/student/courselist";
			}
			else if(data.retCode == -3) //账号错误
			{
				$('#accounterror span').html(data.info.info);
				$('#accounterror').css('display','block');
			}
			else if(data.retCode == -4) //密码错误
			{
				$('#pwderror span').html(data.info.info);
				$('#pwderror').css('display','block');
			}
			else if(data.retCode == -5)  //邮箱错误
			{
				$('#emailerror span').html(data.info.info);
				$('#emailerror').css('display','block');
			}
		}
	});
});
</script>
</body>
</html>

<!DOCTYPE html>
<!-- 
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.0.2
Version: 1.5.4
Author: KeenThemes
Website: http://www.keenthemes.com/
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
-->
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!--> <html lang="en" class="no-js"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
	<meta charset="utf-8" />
	<title>backadmin后台登录</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="width=device-width, initial-scale=1.0" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />
	<meta name="MobileOptimized" content="320">
	<!-- BEGIN GLOBAL MANDATORY STYLES -->          
	<link href="/assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
	<link href="/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
	<link href="/assets/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
	<!-- END GLOBAL MANDATORY STYLES -->
	<!-- BEGIN PAGE LEVEL STYLES --> 
	<link rel="stylesheet" type="text/css" href="/css/login.css" />
	<!-- END PAGE LEVEL SCRIPTS -->
	<!-- BEGIN THEME STYLES --> 
	<link href="/assets/css/style-metronic.css" rel="stylesheet" type="text/css"/>
	<link href="/assets/css/style.css" rel="stylesheet" type="text/css"/>
	<link href="/assets/css/style-responsive.css" rel="stylesheet" type="text/css"/>
	<link href="/assets/css/plugins.css" rel="stylesheet" type="text/css"/>
	<link href="/assets/css/themes/default.css" rel="stylesheet" type="text/css" id="style_color"/>
	<link href="/assets/css/pages/login-soft.css" rel="stylesheet" type="text/css"/>
	<link href="/assets/css/custom.css" rel="stylesheet" type="text/css"/>
	<!-- END THEME STYLES -->
	<link rel="shortcut icon" href="favicon.ico" />
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="login">
	<!-- BEGIN LOGO -->
	<div class="logo">
		<img src="/images/backadminlogo.png" alt="" /> 
	</div>
	<!-- END LOGO -->
	<!-- BEGIN LOGIN -->
	<div class="content">
		<!-- BEGIN LOGIN FORM -->
		<form class="login-form" action="/main/user/login" method="post" style="display:none;">
			<h3 class="form-title">登录账户</h3>
			<?php if(isset($error)) {?>
			<div class="alert alert-danger">
				<button class="close" data-close="alert"></button>
				<span>请输入正确的用户名密码.</span>
			</div>
			<?php }?>
			<div class="form-group">
				<!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
				<label class="control-label visible-ie8 visible-ie9">用户名或邮箱</label>
				<div class="input-icon">
					<i class="fa fa-user"></i>
					<input class="form-control placeholder-no-fix" type="text" autocomplete="on" placeholder="用户名或邮箱" name="name"/>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label visible-ie8 visible-ie9">密码</label>
				<div class="input-icon">
					<i class="fa fa-lock"></i>
					<input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="密码" name="pwd"/>
				</div>
			</div>
            <input name="url" type="hidden" value="<?php if(isset($url)) echo htmlspecialchars($url);?>"/>
			<div class="form-actions">
				<label class="checkbox" id="remember_user">
				<input type="checkbox"  name="remember" value="1"/> 记住用户名
				</label>
				<button name="login_sub" type="submit" class="btn blue pull-right">
				登录 <i class="m-icon-swapright m-icon-white"></i>
				</button>            
			</div>
			<div class="forget-password">
			</div>
			<div class="create-account">
			</div>
		</form>
		<!-- END LOGIN FORM -->        
		<!-- BEGIN FORGOT PASSWORD FORM -->
		<form class="forget-form" action="/main/user/resetpwdEmail" method="post">
			<h3 >重置密码</h3>
			<p>请输入注册时填入的用户名或者邮箱.</p>
			<div class="form-group">
				<div class="input-icon">
					<i class="fa fa-envelope"></i>
					<input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="邮箱或用户名" name="email" />
				</div>
			</div>
			<div class="form-actions">
				<button type="button" id="back-btn" class="btn">
				<i class="m-icon-swapleft"></i> 返回登录
				</button>
				<button type="submit" class="btn blue pull-right">
				发送 <i class="m-icon-swapright m-icon-white"></i>
				</button>            
			</div>
		</form>
		<!-- END FORGOT PASSWORD FORM -->
		<!-- BEGIN REGISTRATION FORM -->
		<form class="register-form" action="" method="post">
			<h3 >注册</h3>
			<div id="reg_error_tip" class="alert alert-danger" style="display:none;">
				<button class="close" data-close="alert"></button>
				<span id="reg_error_tip_info"></span>
			</div>
			<div class="form-group">
				<label class="control-label visible-ie8 visible-ie9">用户名</label>
				<div class="input-icon">
					<i class="fa fa-user"></i>
					<input class="form-control placeholder-no-fix" type="text" autocomplete="on" placeholder="用户名" id="regname" name="name"/>
				</div>
			</div>

			<div class="form-group">
				<label class="control-label visible-ie8 visible-ie9">密码</label>
				<div class="input-icon">
					<i class="fa fa-lock"></i>
					<input class="form-control placeholder-no-fix" type="password" autocomplete="off" id="register_password" placeholder="密码" name="pwd"/>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label visible-ie8 visible-ie9">再次输入密码</label>
				<div class="controls">
					<div class="input-icon">
						<i class="fa fa-check"></i>
						<input class="form-control placeholder-no-fix" type="password" autocomplete="off" id="regpwdconfirm" placeholder="再次输入密码" name="pwdconfirm"/>
					</div>
				</div>
			</div>
			<div class="form-group">
				<!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
				<label class="control-label visible-ie8 visible-ie9">邮箱</label>
				<div class="input-icon">
					<i class="fa fa-envelope"></i>
					<input class="form-control placeholder-no-fix" type="text" id="regemail" autocomplete="on" placeholder="邮箱" name="email"/>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label visible-ie8 visible-ie9">验证码</label>
				<input type="text" name="captcha_code" size="10" maxlength="6" placeholder="验证码" />
				<a href="#" onclick="document.getElementById('captcha').src = '/securimage/securimage_show.php?' + Math.random(); return false">换一换<img style="width:40%" id="captcha" src="/securimage/securimage_show.php" alt="CAPTCHA Image" /></a>
			</div>
			<div class="form-group">
				<label>
				<input type="checkbox" name="tnc"/> 我接受 <a href="#">服务条款</a> 和 <a href="#">隐私政策</a>
				</label>  
				<div id="register_tnc_error"></div>
			</div>
			<div class="form-actions">
				<button id="register-back-btn" type="button" class="btn">
				<i class="m-icon-swapleft"></i>  返回登录
				</button>
				<button type="submit" id="register-submit-btn" class="btn blue pull-right">
				注册 <i class="m-icon-swapright m-icon-white"></i>
				</button>            
			</div>
		</form>
		<form class="resetpwd-form" action="/main/user/resetpwd" method="post" style="display:none;">
			<h3 class="form-title">重置密码</h3>
			<div class="form-group">
				<label class="control-label visible-ie8 visible-ie9">密码</label>
				<div class="input-icon">
					<i class="fa fa-lock"></i>
					<input class="form-control placeholder-no-fix" type="password" autocomplete="off" id="reset_password" placeholder="密码" name="repwd"/>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label visible-ie8 visible-ie9">再次输入密码</label>
				<div class="controls">
					<div class="input-icon">
						<i class="fa fa-check"></i>
						<input class="form-control placeholder-no-fix" type="password" autocomplete="off" id="resetpwdconfirm" placeholder="再次输入密码" name="repwdconfirm"/>
					</div>
				</div>
			</div>
			<input name="confirmid" type="hidden" value="<?php if(isset($confirmid)) echo htmlspecialchars($confirmid);?>"/>
			<input name="u" type="hidden" value="<?php if(isset($u)) echo htmlspecialchars($u);?>"/>
			<input name="resetsub" type="hidden" value="<?php if(isset($isresetpwd)) echo htmlspecialchars($isresetpwd);?>"/>
			<div class="form-actions">
				<button type="submit" id="resetpwd-submit-btn" class="btn blue pull-right">
				确认 <i class="m-icon-swapright m-icon-white"></i>
				</button>            
			</div>
		</form>
		<!-- END REGISTRATION FORM -->
		<div class="infopanel" style="display:none;">
			<h4 class="block">通知您：</h4>
			<div class="well">
			<?php if(isset($infomsg)) echo htmlspecialchars($infomsg);?>
			</div>
			<div class="form-actions">
				<button id="infopanel-back-btn" type="button" class="btn">
				<i class="m-icon-swapleft"></i>  返回登录
				</button>          
			</div>
		</div>
	</div>
	<!-- END LOGIN -->
	<!-- BEGIN COPYRIGHT -->
	<div class="copyright">
		2014 &copy; Back Admin by <a target="_blank" href="http://hucong.net">胡户主</a>.
	</div>
	<!-- END COPYRIGHT -->
	<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
	<!-- BEGIN CORE PLUGINS -->   
	<!--[if lt IE 9]>
	<script src="/assets/plugins/respond.min.js"></script>
	<script src="/assets/plugins/excanvas.min.js"></script> 
	<![endif]-->   
	<script src="/assets/plugins/jquery-1.10.2.min.js" type="text/javascript"></script>
	<script src="/assets/plugins/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
	<script src="/assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="/assets/plugins/bootstrap-hover-dropdown/twitter-bootstrap-hover-dropdown.min.js" type="text/javascript" ></script>
	<script src="/assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
	<script src="/assets/plugins/jquery.blockui.min.js" type="text/javascript"></script>  
	<script src="/assets/plugins/jquery.cookie.min.js" type="text/javascript"></script>
	<script src="/assets/plugins/uniform/jquery.uniform.min.js" type="text/javascript" ></script>
	<!-- END CORE PLUGINS -->
	<!-- BEGIN PAGE LEVEL PLUGINS -->
	<script src="/assets/plugins/jquery-validation/dist/jquery.validate.min.js" type="text/javascript"></script>
	<script src="/assets/plugins/backstretch/jquery.backstretch.min.js" type="text/javascript"></script>
	<script type="text/javascript" src="/assets/plugins/jquery-validation/lib/jquery.form.js"></script>
	<!-- END PAGE LEVEL PLUGINS -->
	<!-- BEGIN PAGE LEVEL SCRIPTS -->
	<script src="/assets/scripts/app.js" type="text/javascript"></script>
	<script src="/js/login.js" type="text/javascript"></script>      
	<!-- END PAGE LEVEL SCRIPTS --> 
	<script>
	jQuery(document).ready(function() {     
		App.init();
		Login.init();


		showinfo = '<?php if(isset($infomsg)) echo htmlspecialchars($infomsg);?>';
		isresetpwd = '<?php if(isset($isresetpwd)) echo htmlspecialchars($isresetpwd);?>';
		if(showinfo) {
		    jQuery('.infopanel').show();
		} else if(isresetpwd) {        
		    jQuery('.resetpwd-form').show();
		} else {        
		    jQuery('.login-form').show();
		}

		// 注册
		showreg = '<?php echo htmlspecialchars($showregister);?>'
		if(showreg) {
			jQuery('.login-form').hide();
			jQuery('.register-form').show();
		}

		// 记住用户名
		username = $.cookie("stock_user_name");
		if(typeof(username) != "undefined"&&username.length!=0) {
			$(".login-form input[name=name]").val(username);
			$("#remember_user span").addClass("checked");	
		}

		$('#errortip').html("");

	});

	</script>
	<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>

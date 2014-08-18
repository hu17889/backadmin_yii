var Login = function () {

	var handleLogin = function() {
		$('.login-form').validate({
	            errorElement: 'span', //default input error message container
	            errorClass: 'help-block', // default input error message class
	            focusInvalid: false, // do not focus the last invalid input
	            rules: {
	                name: {
	                    required: true
	                },
	                pwd: {
	                    required: true
	                },
	                remember: {
	                    required: false
	                }
	            },

	            messages: {
	                name: {
	                    required: "请填入用户名或者邮箱"
	                },
	                pwd: {
	                    required: "请填入密码"
	                }
	            },

	            invalidHandler: function (event, validator) { //display error alert on form submit   
	                $('.alert-danger', $('.login-form')).show();
	            },

	            highlight: function (element) { // hightlight error inputs
	                $(element).closest('.form-group').addClass('has-error'); // set error class to the control group
	            },

	            success: function (label) {
	                label.closest('.form-group').removeClass('has-error');
	                label.remove();
	            },

	            errorPlacement: function (error, element) { // 将error标签插入element的某个位置
	                error.insertAfter(element.closest('.input-icon'));
	            },

	            submitHandler: function (form) {
	                // 记住用户名处理
	                check = $("#remember_user span").hasClass("checked");
	                if(check) $.cookie("stock_user_name",$(".login-form input[name=name]").val());
	                else $.cookie("stock_user_name",'', { expires: -1 });
	                
	                form.submit();
	            }
	        });

	        $('.login-form input').keypress(function (e) {
	            if (e.which == 13) {
	                if ($('.login-form').validate().form()) {
	                    $('.login-form').submit(); // 会调用submitHandle
	                }
	                return false;
	            }
	        });
	}

	var handleForgetPassword = function () {
		$('.forget-form').validate({
	            errorElement: 'span', //default input error message container
	            errorClass: 'help-block', // default input error message class
	            focusInvalid: false, // do not focus the last invalid input
	            ignore: "",
	            rules: {
	                email: {
	                    required: true,
	                    email: true
	                }
	            },

	            messages: {
	                email: {
	                    required: "请填入邮箱",
	                    email: "请填入正确邮箱"
	                }
	            },

	            invalidHandler: function (event, validator) { //display error alert on form submit   

	            },

	            highlight: function (element) { // hightlight error inputs
	                $(element)
	                    .closest('.form-group').addClass('has-error'); // set error class to the control group
	            },

	            success: function (label) {
	                label.closest('.form-group').removeClass('has-error');
	                label.remove();
	            },

	            errorPlacement: function (error, element) {
	                error.insertAfter(element.closest('.input-icon'));
	            },

	            submitHandler: function (form) {
	                form.submit();
	            }
	        });

	        $('.forget-form input').keypress(function (e) {
	            if (e.which == 13) {
	                if ($('.forget-form').validate().form()) {
	                    $('.forget-form').submit();
	                }
	                return false;
	            }
	        });

	        jQuery('#forget-password').click(function () {
	            jQuery('.login-form').hide();
	            jQuery('.forget-form').show();
	        });

	        jQuery('#back-btn').click(function () {
	            jQuery('.login-form').show();
	            jQuery('.forget-form').hide();
	        });

	}

	var handleRegister = function () {

        $('.register-form').validate({
	            errorElement: 'span', //default input error message container
	            errorClass: 'help-block', // default input error message class
	            focusInvalid: false, // do not focus the last invalid input
	            ignore: "",
	            rules: {
	                name: {
	                    required: true
	                },
	                pwd: {
	                    required: true
	                },
	                pwdconfirm: {
	                    equalTo: "#register_password"
	                },
	                email: {
	                    required: true,
	                    email: true
	                },
	                captcha_code: {
	                    required: true
	                },
	                tnc: {
	                    required: true
	                }
	            },

	            messages: { // custom messages for radio buttons and checkboxes
	                name: {
	                    required: "请填入用户名"
	                },
	                pwd: {
	                    required: "请填入密码"
	                },
	                pwdconfirm: {
	                	equalTo: "请填入相同密码"
	                },
	                email: {
	                    required: "请填入邮箱",
	                    email: "请填入正确邮箱"
	                },
	                captcha_code: {
	                    required: "请填入验证码"
	                },
	                tnc: {
	                    required: "请接受服务条款."
	                }
	            },

	            invalidHandler: function (event, validator) { //display error alert on form submit   

	            },

	            highlight: function (element) { // hightlight error inputs
	                $(element).closest('.form-group').addClass('has-error'); // set error class to the control group
	            },

	            success: function (label) {
	                label.closest('.form-group').removeClass('has-error');
	                label.remove();
	            },

	            errorPlacement: function (error, element) {
	                if (element.attr("name") == "tnc") { // insert checkbox errors after the container                  
	                    error.insertAfter($('#register_tnc_error'));
	                } else if (element.closest('.input-icon').size() === 1) {
	                    error.insertAfter(element.closest('.input-icon'));
	                } else {
	                	error.insertAfter(element);
	                }
	            },

	            submitHandler: function (form) {
	            	$(form).ajaxSubmit({
	            		type: "get",
	            		url: "/main/user/register",
	            		dataType: "json",
	            		success: function(result){
					        //返回提示信息       
					        //console.log(result);
					        if(result.retCode==0) {
					        	location.href='/site/index';
					        } else {
					        	// error
					        	console.log(result.msg);
					        	$("#reg_error_tip_info").html(result.msg);
					        	$("#reg_error_tip").show();
					        }
					    }
	                });
	            }
	        });

			$('.register-form input').keypress(function (e) {
	            if (e.which == 13) {
	                if ($('.register-form').validate().form()) {
	                    $('.register-form').submit();
	                }
	                return false;
	            }
	        });

	        jQuery('#register-btn').click(function () {
	            jQuery('.login-form').hide();
	            jQuery('.register-form').show();
	        });

	        jQuery('#register-back-btn').click(function () {
	            jQuery('.login-form').show();
	            jQuery('.register-form').hide();
	        });
	}

	var handleResetpwd = function () {

        $('.resetpwd-form').validate({
	            errorElement: 'span', //default input error message container
	            errorClass: 'help-block', // default input error message class
	            focusInvalid: false, // do not focus the last invalid input
	            ignore: "",
	            rules: {
	                repwd: {
	                    required: true
	                },
	                repwdconfirm: {
	                    equalTo: "#reset_password"
	                }
	            },

	            messages: { // custom messages for radio buttons and checkboxes
	                repwd: {
	                    required: "请填入密码"
	                },
	                repwdconfirm: {
	                	equalTo: "请填入相同密码"
	                }
	            },

	            invalidHandler: function (event, validator) { //display error alert on form submit   

	            },

	            highlight: function (element) { // hightlight error inputs
	                $(element).closest('.form-group').addClass('has-error'); // set error class to the control group
	            },

	            success: function (label) {
	                label.closest('.form-group').removeClass('has-error');
	                label.remove();
	            },

	            errorPlacement: function (error, element) {
	                error.insertAfter(element.closest('.input-icon'));
	            },

	            submitHandler: function (form) {
	            	form.submit();
	            }
	        });

			$('.resetpwd-form input').keypress(function (e) {
	            if (e.which == 13) {
	                if ($('.resetpwd-form').validate().form()) {
	                    $('.resetpwd-form').submit();
	                }
	                return false;
	            }
	        });
	}


	handleInfopanel = function() {
		jQuery('#infopanel-back-btn').click(function () {
            jQuery('.login-form').show();
            jQuery('.infopanel').hide();
        });
	}
    
    return {
        //main function to initiate the module
        init: function () {

            handleLogin();
            handleForgetPassword();
            handleRegister();        
            handleInfopanel();        
            handleResetpwd();
	       
	       	$.backstretch([
		        "assets/img/bg/1.jpg",
		        "assets/img/bg/2.jpg",
		        "assets/img/bg/3.jpg",
		        "assets/img/bg/4.jpg"
		        ], {
		          fade: 1000,
		          duration: 8000
		    });
        }

    };

}();
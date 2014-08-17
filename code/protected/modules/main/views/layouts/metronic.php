<!DOCTYPE html>
<!--[if IE 8]> <html lang="ch" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="ch" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="ch"> <!--<![endif]-->
<head>
   <meta charset="utf-8" />
   <title><?php echo htmlspecialchars($this->actionName);?>-推荐系统后台</title>
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
   
   <!-- BEGIN PAGE LEVEL PLUGIN STYLES --> 
   <!-- data table -->

   <!-- END PAGE LEVEL PLUGIN STYLES -->

   <!-- BEGIN THEME STYLES --> 
   <link href="/assets/css/style-metronic.css" rel="stylesheet" type="text/css"/>
   <link href="/assets/css/style.css" rel="stylesheet" type="text/css"/>
   <link href="/assets/css/style-responsive.css" rel="stylesheet" type="text/css"/>
   <link href="/assets/css/plugins.css" rel="stylesheet" type="text/css"/>
   <link href="/assets/css/pages/tasks.css" rel="stylesheet" type="text/css"/>
   <link href="/assets/css/themes/default.css" rel="stylesheet" type="text/css" id="style_color"/>
   <link href="/assets/css/custom.css" rel="stylesheet" type="text/css"/>
   <!-- END THEME STYLES -->

   <!-- BEGIN MY STYLES --> 
   <link href="/css/backadmin.css" rel="stylesheet" type="text/css"/>
   <!-- END MY STYLES -->

   <script src="/assets/plugins/jquery-1.10.2.min.js" type="text/javascript"></script>
 
   <link rel="shortcut icon" href="favicon.ico" />
</head>

<!-- BEGIN BODY -->
<body class="page-header-fixed">

<!-- BEGIN HEADER -->
<div class="header navbar navbar-inverse navbar-fixed-top">
  <!-- BEGIN TOP NAVIGATION BAR -->
  <div class="header-inner">
    <!-- BEGIN LOGO -->  
    <a class="navbar-brand" href="/site/index">
    <img src="/images/backadminlogo.png" alt="logo" class="img-responsive" />
    </a>
        <!-- 横向菜单-->
        <?php if(Yii::app()->params['horizontal_menu_layout']) { ?>
          <?php $this->widget('application.modules.main.widgets.LeftMenuMetro', array('userid' => $this->userid,'allMenu'=>Yii::app()->params['close_user'],'horiz'=>Yii::app()->params['horizontal_menu_layout'])); ?>
        <?php } ?>
        
      <!-- BEGIN TOP NAVIGATION MENU -->
      <ul class="nav navbar-nav pull-right">
        <!-- BEGIN USER LOGIN DROPDOWN -->
        <?php if(!empty($this->userInfo)) {?>
        <li class="dropdown user">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
          <img alt="" src="/assets/img/avatar1_small.jpg"/>
          <span class="username"><?php echo htmlspecialchars($this->userInfo["uname"]);?></span>
          <i class="fa fa-angle-down"></i>
          </a>
          <ul class="dropdown-menu">
            <li><a href="javascript:;" id="trigger_fullscreen"><i class="fa fa-move"></i>全屏</a></li>
            <!--<li><a href="/main/user/lock"><i class="fa fa-lock"></i>锁屏</a></li>-->
            <li><a href="/main/user/logout"><i class="fa fa-key"></i>退出</a></li>
          </ul>
        </li>
        <?php }?>
        <!-- END USER LOGIN DROPDOWN -->
      </ul>
      <!-- END TOP NAVIGATION MENU -->
  </div>
</div> <!--header-->


<div class="clearfix"></div>
<!-- BEGIN CONTAINER -->
<div class="page-container">
      <!-- BEGIN SIDEBAR -->
      <!-- 纵向菜单-->
      <?php if(!Yii::app()->params['horizontal_menu_layout']) { ?>
      <div class="page-sidebar navbar-collapse collapse">
        <!-- BEGIN SIDEBAR MENU -->        
        <?php $this->widget('application.modules.main.widgets.LeftMenuMetro', array('userid' => $this->userid,'allMenu'=>Yii::app()->params['close_user'])); ?>
        <!-- END SIDEBAR MENU -->
      </div>
      <?php } ?>
      <!-- END SIDEBAR -->
    
    <!-- BEGIN PAGE -->
    <div class="page-content" style="<?php if(Yii::app()->params['horizontal_menu_layout']) echo 'margin-left:0px';?>">
        <!-- BEGIN PAGE HEADER-->
        <div class="row">
          <div class="col-md-12">
            <!-- BEGIN PAGE TITLE & BREADCRUMB-->   
            <?php $this->widget('application.modules.main.widgets.PageTitleMetro', array('userid' => $this->userid)); ?>
            <!-- END PAGE TITLE & BREADCRUMB--> 
          </div>
        </div>
        <!-- END PAGE HEADER-->

        <div class="row">
        <div class='col-md-12'>
          <?php echo $content;?>
        </div>
        </div>
    </div>
    <!-- END PAGE -->
</div>
<!-- END CONTAINER -->

<!-- BEGIN FOOTER -->
<div class="footer">
    <div class="footer-inner">
        2014 &copy; Back Admin by hucong.
    </div>
    <div class="footer-tools">
        <span class="go-top">
        <i class="fa fa-angle-up"></i>
        </span>
    </div>
</div>
<!-- END FOOTER -->



  <!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
  <!-- BEGIN CORE PLUGINS -->   
  <!--[if lt IE 9]>
  <script src="/assets/plugins/respond.min.js"></script>
  <script src="/assets/plugins/excanvas.min.js"></script> 
  <![endif]-->   
  <script src="/assets/plugins/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>   
  <!-- IMPORTANT! Load jquery-ui-1.10.3.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
  <script src="/assets/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js" type="text/javascript"></script>
  <script src="/assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
  <script src="/assets/plugins/bootstrap-hover-dropdown/twitter-bootstrap-hover-dropdown.min.js" type="text/javascript" ></script>
  <script src="/assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
  <script src="/assets/plugins/jquery.blockui.min.js" type="text/javascript"></script>  
  <script src="/assets/plugins/jquery.cookie.min.js" type="text/javascript"></script>
  <script src="/assets/plugins/uniform/jquery.uniform.min.js" type="text/javascript" ></script>
  <!-- END CORE PLUGINS -->

  <!-- BEGIN PAGE LEVEL PLUGINS -->


  <!-- END PAGE LEVEL PLUGINS -->

  <!-- BEGIN PAGE LEVEL SCRIPTS -->
  <script src="/assets/scripts/app.js" type="text/javascript"></script>

  <!-- END PAGE LEVEL SCRIPTS -->  
  <script>
    jQuery(document).ready(function() {    
       App.init(); // initlayout and core plugins
       //Index.init();
       //TableAjax.init();
       /*
       Index.initJQVMAP(); // init index page's custom scripts
       Index.initCalendar(); // init index page's custom scripts
       Index.initCharts(); // init index page's custom scripts
       Index.initChat();
       Index.initMiniCharts();
       Index.initDashboardDaterange();
       Index.initIntro();
       Tasks.initDashboardWidget();
       */
    });
  </script>
  <!-- END JAVASCRIPTS -->
</body>
</html>

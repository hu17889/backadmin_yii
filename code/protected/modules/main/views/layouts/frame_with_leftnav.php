<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $this->actionName;?></title>
<link href="/css/frame.css" rel="stylesheet" media="screen" type="text/css" />
<link href="/css/yongh.css" rel="stylesheet" media="screen" type="text/css" />
<link href="/css/cj_css.css" rel="stylesheet" media="screen" type="text/css" />
<link href="/css/css.css" rel="stylesheet" media="screen" type="text/css" />
<link href="/css/page.css" rel="stylesheet" type="text/css" />

<!--<script type="text/javascript" src="/js/jquery-1.9.1.min.js" ></script>-->
<script type="text/javascript" src="/js/jquery171.js" ></script>
<script src="/js/jquery-ui.js"></script>
<link rel="stylesheet" href="/css/jquery-ui.css" type="text/css" />

<link href="/colorbox/colorbox.css" rel="stylesheet" media="screen" type="text/css" />
<script type="text/javascript" src="/colorbox/jquery.colorbox.js" ></script>

<script type="text/javascript" src="/js/jquery.jqtransform.js" ></script>
<link rel="stylesheet" href="/css/jqtransform.css" type="text/css" media="all" />
<!--  <link rel="stylesheet" href="/css/jqtransform_a.css" type="text/css" media="all" />-->
<script language="javascript">
        $(function(){
            $('form.jqtr').jqTransform();
        });
</script>
</head>
<body>
<div class="bg">
    <div class="head">
        <span class="logo"><img src="/images/frame/logo.png" /></span>
        <span class="home"><a href="/site/index"><img src="/images/frame/home.png" /></a><a href="/main/user/logout"><img src="/images/frame/out.png" /></a></span>
    </div>

    <div class="content">

        <div class="leftnav">
            <div class="Nav_1"><?php echo $this->userInfo['uname'] . ',您好!';?></div>
            <div class="Nav_2"><?php echo date('Y年m月d日',time());?><br /><?php $weekth = intval(date('N',time()));echo $this->weeks[$weekth];?>&nbsp;&nbsp; <?php echo date('G:i:s',time());?></div>
            <?php $this->widget('application.modules.main.widgets.LeftMenu', array('userid' => $this->userid,'type'=>'logo')); ?>
        </div>
        <?php echo $content; ?>
     </div><!--content-->
     <div class="foot">Copyright© 2012 Open Vision. 版权所有&nbsp;&nbsp;</div>
</div>
</body>
</html>

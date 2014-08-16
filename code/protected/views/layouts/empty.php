<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" " http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php if(Yii::app()->getController()->getId()=="test"):?>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/test.css"/>
<?php endif;?>
<script type="text/javascript" src="/js/jquery-1.9.1.min.js"> </script>
<link rel="stylesheet" href="/js/jquery_ui/themes/base/jquery-ui.css" />
<script src="/js/jquery_ui/ui/jquery-ui.js"></script>
</head>
<body>
    <?php echo $content; ?>
</body>
</html>

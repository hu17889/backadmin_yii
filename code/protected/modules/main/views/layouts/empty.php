<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" " http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-1.9.1.min.js"></script>
</head>
<body>
    <p>
    <a href='/main/user/login'>login</a>
    <a href='/main/user/logout'>logout</a>
    </p>
    <?php $this->widget('LeftMenu', array('userid' => $this->userid)); ?>
    <?php echo $content; ?>
</body>
</html>

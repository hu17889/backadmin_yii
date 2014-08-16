<?php if($level==1) {?>
<h3 class="page-title">
  <?php echo htmlspecialchars($curaction['aname']);?>
  <!--<small>statistics and more</small>-->
</h3>
<ul class="page-breadcrumb breadcrumb">
  <li>
    <i class="fa fa-home"></i>
    <a href="#"><?php echo htmlspecialchars($curaction['aname']);?></a> 
  </li>
</ul>
<?php } else if ($level==2) {?>
<h3 class="page-title">
  <?php echo htmlspecialchars($curaction['aname']);?>
  <!--<small>statistics and more</small>-->
</h3>
<ul class="page-breadcrumb breadcrumb">
  <li>
    <i class="fa fa-home"></i>
    <a href="#"><?php echo htmlspecialchars($first['aname']);?></a> 
    <span class="fa fa-angle-right"></span>
  </li>
  <li><a href="#"><?php echo htmlspecialchars($curaction['aname']);?></a></li>
</ul>
<?php }?>
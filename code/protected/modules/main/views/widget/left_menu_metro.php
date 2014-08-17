<ul class="page-sidebar-menu">
	<li>
		<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
		<div class="sidebar-toggler hidden-phone"></div>
		<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
	</li>
	<?php $i=0;foreach($first as $v) {?>
	<?php if($i==0) {  $i=1;?>
	<li class="start" data-aid="<?php echo htmlspecialchars($v['route']);?>">
	<?php } else {?>
	<li class="" data-aid="<?php echo htmlspecialchars($v['route']);?>">
	<?php }?>
		<?php if(!isset($second[$v['aid']])) {?><!--二级菜单-->
		<a href="<?php echo htmlspecialchars($v['route']);?> "> 
			<i class="fa fa-bookmark-o"></i>
			<span class="title"><?php echo htmlspecialchars($v['aname']);?></span>
		</a>
		<?php } else {?>
		<a href="<?php echo htmlspecialchars($v['route']);?> "> 
			<i class="fa fa-bookmark-o"></i>
			<span class="title"><?php echo htmlspecialchars($v['aname']);?></span>
			<span class="arrow "></span>
		</a>
		<ul class="sub-menu">
			<?php foreach($second[$v['aid']] as $v1) { ?>
			<li data-aid="<?php echo htmlspecialchars($v1['route']);?>">
				<a href="<?php echo htmlspecialchars($v1['route']);?>"><?php echo htmlspecialchars($v1['aname']);?></a>
			</li>
			<?php } ?>
		</ul>
		<?php }?>
	</li>
<?php }?>
</ul>

<script>
	(function($){
		pathname = window.location.pathname;
		x = $(".page-sidebar-menu li");
		for(i=0; i<x.length; i++) {
			if($(x[i]).data("aid")==pathname) {
				$(x[i]).addClass("active");
				$(x[i]).parents("li").addClass("active");
				$(x[i]).parents("li").children("a").children(".arrow").addClass("open");
				//$(x[i]).parents("li").children("span.arrow").css("display","block");
			}
		}
	})(jQuery);
</script>

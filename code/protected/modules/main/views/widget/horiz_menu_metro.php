<!-- BEGIN HORIZANTAL MENU -->
<div class="hor-menu hidden-sm hidden-xs">
	<ul class="nav navbar-nav">
		<?php $i=0;foreach($first as $v) {?>
		<li class="" data-aid="<?php echo $v['route'];?>">
			<?php if(!isset($second[$v['aid']])) {?>
			<!--一级菜单-->
			<a href="<?php echo $v['route'];?> "> 
				<span class="title"><?php echo $v['aname'];?></span>
			</a>
			<?php } else {?>
			<!--二级菜单-->
			<a data-toggle="dropdown" data-hover="dropdown" data-close-others="true" class="dropdown-toggle" href="<?php echo $v['route'];?> ">
			<span class="selected"></span>
			<span class="title"><?php echo $v['aname'];?></span>
			<i class="fa fa-angle-down"></i>     
			</a>
			<ul class="dropdown-menu">
				<?php foreach($second[$v['aid']] as $v1) { ?>
				<li data-aid="<?php echo $v1['route'];?>">
					<a href="<?php echo $v1['route'];?>"><?php echo $v1['aname'];?></a>
				</li>
				<?php } ?>
			</ul>
			<?php }?>
		</li>
		<?php }?>
	</ul>
</div>
<!-- END HORIZANTAL MENU -->

<script>
	(function($){
		pathname = window.location.pathname;
		x = $(".hor-menu li");
		for(i=0; i<x.length; i++) {
			if($(x[i]).data("aid")==pathname) {
				$(x[i]).addClass("active");
				$(x[i]).parents("li").addClass("active");
				//$(x[i]).parents("li").children("a").children(".arrow").addClass("open");
				//$(x[i]).parents("li").children("span.arrow").css("display","block");
			}
		}
	})(jQuery);
</script>

<!-- BEGIN SAMPLE FORM PORTLET-->   

<div class="row">
<div class="col-md-6">
<?php if($label=='has_action') { ?>
<div class="alert alert-warning">
	<strong>Error!</strong>已经有此路由信息
</div>
<?php } ?>
<div class="portlet box green ">
	<div class="portlet-title">
		<div class="caption">
			<i class="fa fa-reorder"></i> Route Edit
		</div>
		<div class="tools">
			<a href="" class="collapse"></a>
			<a href="#portlet-config" data-toggle="modal" class="config"></a>
			<a href="" class="reload"></a>
			<a href="" class="remove"></a>
		</div>
	</div>
	<div class="portlet-body form">
		<form class="form-horizontal" role="form" method='post' action='/main/action/edit'>
			<div class="form-body">
				<div class="form-group">
					<label  class="col-md-3 control-label">路由Id</label>
					<div class="col-md-9">
						<input type="text" class="form-control"  name='id' value='<?php echo !empty($entity['aid']) ? htmlspecialchars($entity['aid']):''; ?>' placeholder="<?php echo !empty($entity['aid']) ? htmlspecialchars($entity['aid']):''; ?>" readonly>
					</div>
				</div>
				<div class="form-group">
					<label  class="col-md-3 control-label">是否侧栏菜单</label>
					<div class="col-md-9">
						<select  id='menu_type' name='menu_type' class="form-control">
							<option value="0">不是菜单</option>
							<option value="1">一级菜单</option>
							<option value="2">二级菜单</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label  class="col-md-3 control-label">菜单排序</label>
					<div class="col-md-9">
						<input type="text" class="form-control"  name='menusort' value='<?php echo !empty($entity['menusort']) ? htmlspecialchars($entity['menusort']):'0'; ?>' placeholder="菜单排序值">
						<span class="help-block">输入范围（1-100）</span>
					</div>
				</div>
				<div id='firstmenu' class="form-group" style='display:none'>
					<label  class="col-md-3 control-label">一级菜单</label>
					<div class="col-md-9">
						<select name='firstmenu' class="form-control">
							<option value="">请选择</option>
							<?php foreach ($firstmenus as $v) {?>
							<option value="<?php echo htmlspecialchars($v['aid'])?>"><?php echo htmlspecialchars($v['aname'])?></option>
							<?php }?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label  class="col-md-3 control-label">路由名</label>
					<div class="col-md-9">
						<input type="text" class="form-control"  placeholder="Enter text" name='name' value='<?php echo !empty($entity['aname']) ? htmlspecialchars($entity['aname']):''; ?> '>
						<span class="help-block">例：编辑路由</span>
					</div>
				</div>
				<div class="form-group">
					<label  class="col-md-3 control-label">路由信息</label>
					<div class="col-md-9">
						<input type="text" class="form-control"  placeholder="Enter text" name='route' value='<?php echo !empty($entity['route']) ? htmlspecialchars($entity['route']):''; ?> '>
						<span class="help-block">例：/main/action/edit</span>
					</div>
				</div>
			</div>
			<div class="form-actions fluid">
				<div class="col-md-offset-3 col-md-9">
					<input type="submit" name='modify' value='Submit' class="btn green">
					<button id="cancel" type="button" class="btn default">Cancel</button>                              
				</div>
			</div>
		</form>
	</div>
</div>
</div>
</div>
<!-- END SAMPLE FORM PORTLET-->




<script>
(function($){
	menuType = "<?php echo isset($entity["is_menu"]) ? htmlspecialchars($entity["is_menu"]) : 0;?>";
	if(menuType!="0") {
		$("#firstmenu").show();
		$('#firstmenu select').val('<?php echo isset($entity["first_menu"]) ?  htmlspecialchars($entity["first_menu"]) : "";?>');
	}
	$('#menu_type').val(menuType);
	
	$('#firstmenu select').val('<?php echo isset($entity["first_menu"]) ?  htmlspecialchars($entity["first_menu"]) : "";?>');
	showFirstMenu = function(){
		elem = $("#menu_type").children('option:selected').val();
		if(elem=="2") $('#firstmenu').show();
		else $('#firstmenu').hide();

	};
	showFirstMenu();

	$("#menu_type").on('change', showFirstMenu);

    $('#cancel').on("click",function(){
        location.href="/main/action/list";
    });
})(jQuery);
</script>

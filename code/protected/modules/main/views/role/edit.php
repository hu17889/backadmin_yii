
<div class="row">
<div class="col-md-6">
<?php if($label=='has_role') { ?>
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
        <form class="form-horizontal" role="form" method='post' action='/main/role/edit'>
            <div class="form-body">
                <div class="form-group">
                    <label  class="col-md-3 control-label">角色Id</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control"  name='id' value='<?php echo !empty($entity['rid']) ? htmlspecialchars($entity['rid']):''; ?>' readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label  class="col-md-3 control-label">角色名</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control"  placeholder="Enter text" name='name' value='<?php echo !empty($entity['rname']) ? htmlspecialchars($entity['rname']):''; ?> '>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">功能权限设置</label>
                    <div class="col-md-9">
                        <div class="checkbox-list">
                            <?php $i=0;foreach($action_list as $controllername=>$actions) { ?>
                                <hr>
                                <h3><?php echo htmlspecialchars($controllername);?></h3>
                                <?php foreach($actions as $key=>$action) { ?>
                                <?php $check = !empty($entity['actions'])&&isset($entity['actions'][$action['aid']]) ? 'checked' : '';?>
                                <label>
                                <input type='checkbox' name='actions[<?php echo $i;?>]' value='<?php echo htmlspecialchars($action['aid']); ?>' <?php echo $check;?> /><?php echo htmlspecialchars($action['aname']); ?> <?php echo htmlspecialchars($action['route']); ?>
                                </label>
                                <?php $i++;} ?>
                            <?php } ?>
                        </div>
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



<script type='text/javascript'>
(function($) {
    $("input[type=checkbox]").on('click',function() {
        name = "#position_"+$(this).val();
        if($(this).attr('checked')) {
            $(name).css('display','');
        } else {
            $(name).css('display','none');
        }
    });

    $('#cancel').on("click",function(){
        location.href="/main/role/list";
    });
})(jQuery)
</script>

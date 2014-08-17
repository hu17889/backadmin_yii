<!-- BEGIN SAMPLE FORM PORTLET-->   

<div class="row">
<div class="col-md-6">
<?php if($label=='has_usr') { ?>
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
    <form class="form-horizontal" role="form" method='post' action='/main/user/edit'>
      <div class="form-body">
        <div class="form-group">
          <label  class="col-md-3 control-label">用户Id</label>
          <div class="col-md-9">
            <input type="text" class="form-control"  name='id' value='<?php echo !empty($entity['uid']) ? htmlspecialchars($entity['uid']):''; ?>' placeholder="<?php echo !empty($entity['uid']) ? htmlspecialchars($entity['uid']):''; ?>" readonly>
          </div>
        </div>
        <div class="form-group">
          <label  class="col-md-3 control-label">用户名</label>
          <div class="col-md-9">
            <input type="text" class="form-control"  name='name' value='<?php echo !empty($entity['uname']) ? htmlspecialchars($entity['uname']):''; ?>' placeholder="<?php echo !empty($entity['uname']) ? htmlspecialchars($entity['uname']):''; ?>" >
          </div>
        </div>
        <div class="form-group">
          <label  class="col-md-3 control-label">密码</label>
          <div class="col-md-9">
            <input type="text" class="form-control"  name='pwd' value='' placeholder="" >
          </div>
        </div>
        <div class="form-group">
          <label  class="col-md-3 control-label">邮箱</label>
          <div class="col-md-9">
            <input type="text" class="form-control"  name='email' value='<?php echo !empty($entity['email']) ? htmlspecialchars($entity['email']):''; ?>' placeholder="<?php echo !empty($entity['email']) ? htmlspecialchars($entity['email']):''; ?>" >
          </div>
        </div>
        <div id='rolemenu' class="form-group" >
          <label  class="col-md-3 control-label">用户角色</label>
          <div class="col-md-9">
            <select name='rid' class="form-control">
              <?php foreach ($roles as $v) {?>
              <option value="<?php echo htmlspecialchars($v['rid'])?>"><?php echo htmlspecialchars($v['rname'])?></option>
              <?php }?>
            </select>
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
(function($){
    $('#rolemenu select').val('<?php echo isset($entity["rid"]) ?  htmlspecialchars($entity["rid"]) : "1";?>');

    $('#cancel').on("click",function(){
        location.href="/main/user/list";
    });
})(jQuery)
</script>

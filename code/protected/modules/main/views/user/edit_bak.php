<?php if($label=='has_usr') { ?>
<div class='tip'>已经有此用户</div>
<?php } ?>
<form method='post' action='/main/user/edit'>
用戶id:<?php echo !empty($entity['uid']) ? $entity['uid']:''; ?>
<input type='hidden' name='id' value='<?php echo !empty($entity['uid']) ? $entity['uid']:''; ?>' /><br>
账号:<input type='text' name='name' value='<?php echo !empty($entity['uname']) ? htmlspecialchars($entity['uname']):'';?>'/><br>
邮箱:<input type='text' name='email' value='<?php echo !empty($entity['email']) ? htmlspecialchars($entity['email']):'';?>'/><br>
密码:<input type='password' name='pwd' value='<?php echo !empty($entity['pwd']) ? htmlspecialchars($entity['pwd']):'';?>'/><br>
<select id='role_select' name='rid'>
<?php foreach($roles as $role) {?>
<option value ="<?php echo $role['rid'];?>"><?php echo htmlspecialchars($role['rname']);?></option>
<?php }?>
</select>
<input type='submit' name='modify' value="提交">
</form>

<script type='text/javascript'>
(function($){
    roleid = '<?php echo !empty($entity['rid']) ? $entity['rid']:''; ?>';
    console.log(roleid);
    $("#role_select option[value='"+roleid+"']").attr('selected','selected');
})(jQuery)
</script>

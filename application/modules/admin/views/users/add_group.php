<?php if(isset($redirect)) {echo $redirect;}else{?>
<div class="fluid">
	<iframe frameborder="0" width="0" height="0" id="myIframe" name="myIframe"></iframe>
	<form class="formElement" method="post" id="users_form" name="users_formAdd" target="myIframe" action="<?php echo DIR_ROOT?>admin/users/addGroup<?php echo $param;?>">
		<div class="widget">
			<div class="whead"><h6><?php echo lang('web_add')." group";?></h6><div class="clear"></div></div>
	        
			<div id="showWarning"></div>
			<div class="formRow">
				<div class="grid3">
					<label class="lbl fl" for="admin_group_desc">ชื่อกลุ่ม</label>
					<span class="required"></span>
				</div>
				<div class="grid9">
					<input type="text" id="admin_group_desc" name="admin_group_desc" class="inpt">
				</div>
				<div class="clear"></div>
			</div>

			<div class="formRow">
				<input type="submit" value="<?php echo lang('web_save');?>" class="buttonM bGreen formSubmit"></input>
				<div class="clear"></div>
			</div>
		</div>
	</form>
</div>
<script>
$("#users_form").validate({
	rules: {
		admin_group_desc: {
			required: true
		}
   },
   submitHandler: function(form) {
		document.users_formAdd.submit();
 	}
});
</script>
<?php }?>
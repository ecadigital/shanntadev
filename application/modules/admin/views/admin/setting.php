<?php if(!isset($success)){?>
<div class="fluid">
	<iframe frameborder="0" width="0" height="0" id="myIframe" name="myIframe"></iframe>
	<form class="formElement" method="post" id="admin_config" name="admin_config" target="myIframe">
		<div class="widget">
			<div class="whead"><h6>Setting : General</h6><div class="clear"></div></div>

		<div id="showWarning"></div>
		<?php foreach($listEditSetting as $list){?>
		<div class="formRow">
			<div class="grid3">
				<label class="lbl fl" for="admin_cfg_detail"><?php echo $list['admin_cfg_detail'];?></label>
				<span class="required"></span>
			</div>
			<div class="grid9">
				<input type="text" id="<?php echo $list['admin_cfg_name'];?>" name="cfg[<?php echo $list['admin_cfg_id'];?>]" class="inpt" value="<?php echo ($list['admin_cfg_value']!='')?$list['admin_cfg_value']:$list['admin_cfg_default'];?>" onblur="if (this.value == '') {this.value = '<?php echo $list['admin_cfg_default'];?>';}">
			</div>
			<div class="clear"></div>
		</div>
		<?php }?>
		<div class="formRow">
				<input type="hidden" id="captcha" name="captcha" value=""></input>
				<input type="submit" value="<?php echo lang('web_save');?>" class="buttonM bGreen formSubmit"></input>
				<div class="clear"></div>
			</div>
		</div>
	</form>
</div>
<script>
$("#admin_config").validate({
   	submitHandler: function(form) {
		document.admin_config.submit();
 	}
});
</script>
<?php }else{echo $success;}?>
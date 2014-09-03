<?php if(isset($redirect)) {echo $redirect;}else{?>
<div class="fluid">
	<form class="formElement" method="post" id="menu_form" name="menu_formAdd" enctype="multipart/form-data" action="<?php echo DIR_ROOT?>menu/admin/add">
	<div class="widget">
		<div class="whead"><h6><?php echo lang('web_add');?></h6><div class="clear"></div></div>
			<div id="showWarning"></div>
			<div class="formRow">
				<div class="grid3">
					<label class="lbl" for="menu_parent_id"><?php echo lang('web_parent');?></label>
				</div>
				<select id="menu_parent_id" name="menu_parent_id">
					<option value="0">--</option>
					<?php if(!empty($listMenuParent)){foreach($listMenuParent as $list){?>
					<option value="<?php echo $list["menu_id"]?>" <?php echo ($list["menu_id"]=='3')?'selected="selected"':'';?> ><?php echo $list["menu_desc"]?></option>
					<?php }}?>
				</select>
			</div>
			<div class="formRow">
				<div class="grid3">
					<label class="lbl" for="menu_desc"><?php echo lang('web_menu_name');?> </label>
					<span class="required"></span>
				</div>
				<div class="grid9">
					<input type="text" id="menu_desc" name="menu_desc" class="inpt" >
				</div>
				<div class="clear"></div>
			</div>
			<div class="formRow">
				<div class="grid3">
					<label class="lbl" for="menu_admin_link"><?php echo lang('web_link');?></label>
					<span class="required"></span>
				</div>
				<div class="grid9">
					<input type="text" id="menu_admin_link" name="menu_admin_link" class="inpt">
				</div>
				<div class="clear"></div>
			</div>
			
			<div class="formRow">
				<fieldset>
					<legend><?php echo lang('web_published');?></legend>
					<div class="clearfix">
						<div class="grid9">
							<input type="radio" value="1" id="published" name="menu_published_admin" checked="checked">
							<label class="lbl_inline" for="published"><?php echo lang('web_published');?></label>
						</div>
						<div class="grid9">
							<input type="radio" value="0" id="unpublished" name="menu_published_admin">
							<label class="lbl_inline" for="unpublished"><?php echo lang('web_unpublished');?></label>
						</div>
					</div>
				</fieldset>
			</div>
			
			<div class="formRow">
				<fieldset>
					<legend><?php echo lang('web_menu_type');?></legend>
						<div class="grid9">
							<input type="radio" value="A" id="menutype_admin_A" name="menu_menutype_admin" checked="checked">
							<label class="lbl_inline" for="menutype_admin_A"><?php echo lang('web_menu_ajax');?></label>
						</div>
						<div class="grid9">
							<input type="radio" value="H" id="menutype_admin_H" name="menu_menutype_admin">
							<label class="lbl_inline" for="menutype_admin_H"><?php echo lang('web_menu_href');?></label>
						</div>
						<div class="grid9">
							<input type="radio" value="L" id="menutype_admin_L" name="menu_menutype_admin">
							<label class="lbl_inline" for="menutype_admin_L"><?php echo lang('web_menu_label');?></label>
						</div>
				</fieldset>
			</div>
			
			<div class="formRow">
				<fieldset>
					<legend><?php echo lang('web_access');?></legend>
					
					<?php foreach($listGroupUser as $key=>$list){if($list['admin_group_id']!=1){?>
					<div class="grid9">
						<input type="checkbox" class="check" id="admin_group_<?php echo $list['admin_group_id'];?>" name="admin_group_id[]" value="<?php echo $list['admin_group_id'];?>" />&nbsp;&nbsp;<label for='admin_group_<?php echo $list['admin_group_id'];?>'><?php echo $list['admin_group_desc'];?></label>
					</div>
					<?php }}?>
					
				</fieldset>
			</div>
			
			<div class="formRow">
				<div class="grid3">
					<label class="lbl" for="userfile">icon</label>
				</div>
				<input type="file" id="userfile" name="userfile" size="40">
			</div>
			
			<div class="formRow">
				<input type="submit" value="<?php echo lang('web_save');?>" class="buttonM bGreen formSubmit"></input>
				<div class="clear"></div>
			</div>
		</div>
	</form>
</div>
<script>
$("#menu_form").validate({
	rules: {
		menu_desc: {
			required: true
		},
		menu_admin_link: {
			required: true
		}
   },
   submitHandler: function(form) {
		document.menu_formAdd.submit();
 	}
});
</script>
<?php }?>
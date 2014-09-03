<?php if(isset($redirect)) {echo $redirect;}else{?>
<div class="fluid">

<!--	<iframe frameborder="0" width="0" height="0" id="myIframe" name="myIframe"></iframe>-->
	<form class="formElement" method="post" id="menu_form" name="menu_formEdit" enctype="multipart/form-data" action="<?php echo DIR_ROOT?>menu/admin/edit"> <!-- target="myIframe" -->
		<div class="widget">
			<div class="whead"><h6><?php echo lang('web_edit');?></h6><div class="clear"></div></div>
			
			<div class="formRow">
				<div class="grid3">
					<label class="lbl" for="menu_parent_id"><?php echo lang('web_parent');?></label>
				</div>
				<select id="menu_parent_id" name="menu_parent_id" class="select" style="min-width: 200px;">
					<option value="0">--</option>
					<?php if(!empty($listMenuParent)){foreach($listMenuParent as $list){?>
					<option value="<?php echo $list["menu_id"]?>" <?php echo ($list["menu_id"]==$listEdit['menu_parent_id'])?'selected="selected"':'';?>><?php echo $list["menu_desc"]?></option>
					<?php }}?>
				</select>
			</div>
			
			<div class="formRow">
				<div class="grid3">
					<label class="lbl" for="menu_desc"><?php echo lang('web_menu_name');?></label>
					<span class="required"></span>
				</div>
				<input type="text" id="menu_desc" name="menu_desc" class="inpt validate[required]" value="<?php echo $listEdit['menu_desc'];?>">
			</div>
			
			<div class="formRow">
				<div class="grid3">
					<label class="lbl" for="menu_admin_link"><?php echo lang('web_link');?></label>
					<span class="required"></span>
				</div>
				<input type="text" id="menu_admin_link" name="menu_admin_link" class="inpt validate[required]" value="<?php echo $listEdit['menu_admin_link'];?>">
			</div>
			
			<div class="formRow">
				<fieldset>
					<legend><?php echo lang('web_published');?></legend>
					<div class="grid9">
						<input type="radio" value="1" id="published" name="menu_published_admin" <?php echo ($listEdit['menu_published_admin']==1)?' checked="checked"':'';?>>
						<label for="published"><?php echo lang('web_published');?></label>
					</div>
					<div class="grid9">
						<input type="radio" value="0" id="unpublished" name="menu_published_admin" <?php echo ($listEdit['menu_published_admin']==0)?' checked="checked"':'';?>>
						<label for="unpublished"><?php echo lang('web_unpublished');?></label>
					</div>
				</fieldset>
			</div>
			<div class="formRow">
				<fieldset>
					<legend><?php echo lang('web_menu_type');?></legend>
					<div class="grid9">
						<input type="radio" value="A" id="menutype_admin_A" name="menu_menutype_admin" <?php echo ($listEdit['menu_menutype_admin']=='A')?' checked="checked"':'';?>>
						<label for="menutype_admin_A"><?php echo lang('web_menu_ajax');?></label>
					</div>
					<div class="grid9">
						<input type="radio" value="H" id="menutype_admin_H" name="menu_menutype_admin" <?php echo ($listEdit['menu_menutype_admin']=='H')?' checked="checked"':'';?>>
						<label for="menutype_admin_H"><?php echo lang('web_menu_href');?></label>
					</div>
					<div class="grid9">
						<input type="radio" value="L" id="menutype_admin_L" name="menu_menutype_admin" <?php echo ($listEdit['menu_menutype_admin']=='L')?' checked="checked"':'';?>>
						<label for="menutype_admin_L"><?php echo lang('web_menu_label');?></label>
					</div>
				</fieldset>
			</div>
			<div class="formRow">
				<fieldset>
					<legend><?php echo lang('web_access');?></legend>
					<!--		จะไม่แสดง Root เนื่องจาก root จะสามารถใช้งานได้ทุกโมดูลโดยอัตโนมัติ		-->
					<?php 
					$listUserGroup=explode(',',$listEdit['menu_admin_group']);
					foreach($listGroupUser as $key=>$list){if($list['admin_group_id']!=1){?>
					<div class="grid9">
						<input type="checkbox" class="check" id="admin_group_<?php echo $list['admin_group_id'];?>" name="admin_group_id[]" value="<?php echo $list['admin_group_id'];?>" <?php echo (in_array($list['admin_group_id'],$listUserGroup))?'checked="checked"':'';?> />&nbsp;&nbsp;<label for='admin_group_<?php echo $list['admin_group_id'];?>'><?php echo $list['admin_group_desc'];?></label>
					</div>
					<?php }}?>
				</fieldset>
			</div>
			<div class="formRow">
				<div class="grid3">
					<label class="lbl" for="userfile">icon</label>
				</div>
				<?php if($listEdit['menu_imgpath_admin']!=""){?>
					<div id="wrap-image">
						<img src="<?php echo DIR_ROOT.$listEdit['menu_imgpath_admin']?>" />
						<a href="javascript:void(0);" onclick="confirmDialog('do you want to delete ?','loadAjax(\'<?php echo DIR_ROOT?>menu/admin/delete_image/id/<?php echo $listEdit['menu_id']?>\',\'\',\'removeTarget(\\\'#wrap-image\\\')\')','<?php echo lang('web_ok');?>','<?php echo lang('web_cancel');?>')">
						<img src="<?php echo DIR_PUBLIC;?>images/icons/cross.png" style="width: 20px;vertical-align: bottom;padding-left: 6px;"/></a>
						<input type="hidden" id="image_path" name="image_path" value="<?php echo $listEdit['menu_imgpath_admin'];?>">
					</div>
				<?php }?>
				<input type="file" id="userfile" name="userfile" size="40">
			</div>
			
			<div class="formRow">
				<input type="hidden" id="menu_old_parent" name="menu_old_parent" value="<?php echo $listEdit['menu_parent_id']?>"></input>
				<input type="hidden" id="menu_seq" name="menu_seq" value="<?php echo $listEdit['menu_seq']?>"></input>
				<input type="hidden" id="menu_id" name="menu_id" value="<?php echo $listEdit['menu_id']?>"></input>
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
<?php if(isset($redirect)) {echo $redirect;}else{?>
<div class="clearfix">
	<div class="fr">
		<button class="btn btn_blue sep_bo" onclick="loadAjax('<?php echo DIR_ROOT?>language/index/index','#','')"><span><?php echo lang('web_back');?></span></button>
	</div>
</div>
<iframe frameborder="0" width="0" height="0" id="myIframe" name="myIframe"></iframe>
	<form class="formElement" method="post" id="language_form" name="language_formEdit" enctype="multipart/form-data" target="myIframe" action="<?php echo DIR_ROOT?>language/index/edit">
	<fieldset class="brdrrad_4">
	<legend><h1><?php echo lang('web_edit');?></h1></legend>
		<div id="showWarning"></div>
		<div class="sep_bo">
			<label class="lbl fl" for="language_name"><?php echo lang('web_lang');?></label>
			<span class="required"></span><div class="clearfix"></div>
			<input type="text" id="language_name" name="language_name" class="inpt" value="<?php echo $listEdit['language_name']?>" >
		</div>
		<div class="sep_bo">
			<label class="lbl fl" for="language_alias"><?php echo lang('web_alias');?></label>
			<span class="required"></span><div class="clearfix"></div>
			<input type="text" id="language_alias" name="language_alias" class="inpt" value="<?php echo $listEdit['language_alias']?>" >
		</div>
		<div class="sep_bo">
			<label class="lbl" for="language_desc"><?php echo lang('web_desc');?></label>
			<input type="text" id="language_desc" name="language_desc" class="inpt" value="<?php echo $listEdit['language_desc']?>" >
		</div>
		<div class="sep_bo">
			<label class="lbl" for="userfile"><?php echo lang('web_image');?></label>
			<?php if($listEdit['language_icon']!=""){?>
				<div id="wrap-image" class="sep_bo">
					<img src="<?php echo DIR_ROOT.$listEdit['language_icon']?>" />
					<a href="javascript:void(0);" onclick="confirmDialog('do you want to delete ?','loadAjax(\'<?php echo DIR_ROOT?>language/index/delete_image/id/<?php echo $listEdit['language_id']?>\',\'\',\'removeTarget(\\\'#wrap-image\\\')\')','ตกลง','ยกเลิก')">
					<img src="<?php echo DIR_PUBLIC;?>images/icons/cross.png" style="width: 20px;vertical-align: bottom;padding-left: 6px;"/></a>
					<input type="hidden" id="language_icon" name="language_icon" value="<?php echo $listEdit['language_icon'];?>">
				</div>
			<?php }?>
			<input type="file" id="userfile" name="userfile" size="40">
		</div>
		
		<input type="hidden" id-="language_id" name="language_id" value="<?php echo $listEdit['language_id']?>"></input>
		<input type="hidden" id-="captcha" name="captcha" value=""></input>
		<input type="submit" value="<?php echo lang('web_save');?>" class="btn"></input>
	</fieldset>
</form>
<script>
$("#language_form").validate({
	rules: {
		language_name: {
			required: true
		},
		language_alias: {
			required: true
		}
   },
   submitHandler: function(form) {
		document.language_formEdit.submit();
 	}
});
</script>
<?php }?>
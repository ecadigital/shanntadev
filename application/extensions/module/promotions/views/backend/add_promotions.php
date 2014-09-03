<?php if(!isset($redirect)){?>
<div class="clearfix">
	<div class="fr">
		<button class="btn btn_blue sep_bo" onclick="loadAjax('<?php echo DIR_ROOT?>promotions/backend/index','#','')"><span><?php echo lang('web_back');?></span></button>
	</div>
</div>
<iframe frameborder="0" width="0" height="0" id="myIframe" name="myIframe"></iframe>
	<form class="formElement" method="post" id="promotions_form" name="promotions_formAdd" target="myIframe" enctype="multipart/form-data" action="<?php echo DIR_ROOT?>promotions/backend/add_promotions">
		<fieldset class="brdrrad_4">
		<legend><h1><?php echo lang('web_new')." : ".lang('promotions_ii');?></h1></legend>
			<div id="showWarning"></div>
			<?php if($listAllLang){foreach($listAllLang as $lang){
					$lang_icon = ($lang['language_icon'] != '')?'<img src="'.DIR_ROOT.$lang['language_icon'].'" title="'.$lang['language_desc'].'" style="margin-left:3px;" />':'';
			?>
			<fieldset class="brdrrad_4">
			<legend><?php echo $lang['language_desc'].$lang_icon;?></legend>
				
				<div class="sep_bo">
					<label class="lbl fl" for="promotions_name[<?php echo $lang['language_id']?>]"><?php echo lang('promotions_name');?></label>
					<span class="required"></span><div class="clearfix"></div>
					<input type="text" id="promotions_name[<?php echo $lang['language_id']?>]" name="promotions_name[<?php echo $lang['language_id']?>]" class="inpt">
				</div>
				<div class="sep_bo">
					<label class="lbl" for="promotions_detail[<?php echo $lang['language_id']?>]"><?php echo lang('web_desc');?></label>
					<textarea id="promotions_detail[<?php echo $lang['language_id']?>]" name="promotions_detail[<?php echo $lang['language_id']?>]" class="mceEditor"></textarea>
				</div>
				<div class="sep_bo">
					<label class="lbl" for="userfile[<?php echo $lang['language_id']?>]"><?php echo lang('web_image')?></label>
					<input type="file" id="userfile[<?php echo $lang['language_id']?>]" name="userfile<?php echo $lang['language_id']?>">
				</div>
			</fieldset>
			<?php }}?>

			<fieldset class="brdrrad_4 lbl">
				<legend class="sep_bo"><?php echo lang('web_publish');?></legend>
				<div class="clearfix">
					<span class="dp100">
						<label for='promotions_publish_1'><input type="radio" id="promotions_publish_1" name="promotions_publish" value="1" checked="checked"/>&nbsp;&nbsp;<?php echo lang('web_publish');?></label>
					</span>
					<span class="dp100">
						<label for='promotions_publish_0'><input type="radio" id="promotions_publish_0" name="promotions_publish" value="0" />&nbsp;&nbsp;<?php echo lang('web_unpublish');?></label>
					</span>
				</div>
			</fieldset>
			<input type="hidden" id="captcha" name="captcha" value=""></input>
			<input type="submit" value="<?php echo lang('web_save');?>" class="btn"></input>

		</fieldset>
	</form>
<script>
$("#promotions_form").validate({
	rules: {
			<?php if(!empty($listAllLang)){foreach($listAllLang as $lang){?>
			'promotions_name[<?php echo $lang["language_id"];?>]' : {
				required: true,
			},
			<?php }}?>
   },
   submitHandler: function(form) {
		document.promotions_formAdd.submit();
 	}
});
LoadTinyMCE();
</script>
<?php }else{echo $redirect;}?>
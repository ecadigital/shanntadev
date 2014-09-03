<iframe frameborder="0" width="0" height="0" id="myIframe" name="myIframe"></iframe>
	<form class="formElement" method="post" id="contact_detail_form" name="contact_detail_formAdd" enctype="multipart/form-data" target="myIframe" action="<?php echo DIR_ROOT?>contactus/backend/contactDetail">
		<div id="showWarning"></div>
		<fieldset class="brdrrad_4">
			<div class="sep_bo">
				<label class="lbl fl" for="contactus_detail_name"><?php echo lang('web_name');?> Web Master</label>
				<span class="required"></span><div class="clearfix"></div>
				<input type="text" id="contactus_detail_name" name="contactus_detail_name" class="inpt" value="<?php echo $listEdit['contactus_detail_name']?>">
			</div>
			<div class="sep_bo">
				<label class="lbl fl" for="contactus_detail_company">ชื่อบริษัท</label>
				<span class="required"></span><div class="clearfix"></div>
				<input type="text" id="contactus_detail_company" name="contactus_detail_company" class="inpt" value="<?php echo $listEdit['contactus_detail_company']?>" >
			</div>
			<div class="sep_bo">
				<label class="lbl fl" for="contactus_detail_email">ที่อยู่</label>
				<span class="required"></span><div class="clearfix"></div>
				<textarea id="contactus_detail_address" name="contactus_detail_address" cols="50"><?php echo $listEdit['contactus_detail_address']?></textarea>
			</div>
			<div class="sep_bo">
				<label class="lbl fl" for="contactus_detail_tel"><?php echo lang('web_tel');?></label>
				<span class="required"></span><div class="clearfix"></div>
				<input type="text" id="contactus_detail_tel" name="contactus_detail_tel" class="inpt" value="<?php echo $listEdit['contactus_detail_tel']?>" >
			</div>
			<div class="sep_bo">
				<label class="lbl fl" for="contactus_detail_fax"><?php echo lang('web_fax');?></label>
				<span class="required"></span><div class="clearfix"></div>
				<input type="text" id="contactus_detail_fax" name="contactus_detail_fax" class="inpt" value="<?php echo $listEdit['contactus_detail_fax']?>" >
			</div>
			<div class="sep_bo">
				<label class="lbl fl" for="contactus_detail_email"><?php echo lang('web_email');?></label>
				<span class="required"></span><div class="clearfix"></div>
				<input type="text" id="contactus_detail_email" name="contactus_detail_email" class="inpt" value="<?php echo $listEdit['contactus_detail_email']?>" >
			</div>
            <div class="sep_bo">
                <label class="lbl" for="file_upload"><?php echo lang('contactus_map');?></label>
				<?php if($listEdit['contactus_detail_map']!=""){?>
                    <div id="wrap-image" class="sep_bo">
                        <img src="<?php echo DIR_ROOT.$listEdit['contactus_detail_map']?>" />
                    </div>
                    <input type="hidden" id="image_path" name="image_path" value="<?php echo $listEdit['contactus_detail_map'];?>">
                <?php }?>
                <input type="file" id="file_upload" name="file_upload">
            </div>
			<fieldset class="brdrrad_4 lbl">
				<legend class="sep_bo"><?php echo lang('contactus_type');?></legend>
				<div class="clearfix">
					<span class="dp100">
						<label for='contactus_detail_type1'><input type="radio" id="contactus_detail_type1" name="contactus_detail_type" value="1" <?php echo ($listEdit['contactus_detail_type'] == 1)?'checked="checked"':'';?>/>&nbsp;&nbsp;<?php echo lang('contactus_sendmail_only');?></label>
					</span>
					<span class="dp100">
						<label for='contactus_detail_type2'><input type="radio" id="contactus_detail_type2" name="contactus_detail_type" value="2" <?php echo ($listEdit['contactus_detail_type'] == 2)?'checked="checked"':'';?>/>&nbsp;&nbsp;<?php echo lang('contactus_db_only');?></label>
					</span>
					<span class="dp100">
						<label for='contactus_detail_type3'><input type="radio" id="contactus_detail_type3" name="contactus_detail_type" value="3" <?php echo ($listEdit['contactus_detail_type'] == 3)?'checked="checked"':'';?>/>&nbsp;&nbsp;<?php echo lang('contactus_sendmail_and_db');?></label>
					</span>
				</div>
			</fieldset>
			<input type="hidden" id="captcha" name="captcha" value=""></input>
			<input type="submit" value="<?php echo lang('web_save');?>" class="btn"></input>
		</fieldset>
	</form>
<script>
$("#contact_detail_form").validate({
	rules: {
		contactus_detail_name: {
			required: true,
		},
		contactus_detail_email: {
			required: true,
			email:true
		}
   },
   submitHandler: function(form) {
		document.contact_detail_formAdd.submit();
 	}
});
</script>
<?php if(isset($success)) {echo $success;}?>
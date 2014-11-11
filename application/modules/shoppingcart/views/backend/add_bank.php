<?php if(isset($redirect)){ echo $redirect; }else{ ?>

<h3>เพิ่มบัญชีธนาคาร</h3>
<div>
	<a href="<?php echo DIR_ROOT?>admin/admin/index">หน้าแรก</a>&nbsp;&nbsp;>&nbsp;&nbsp;
    <a href="<?php echo DIR_ROOT?>shoppingcart/backend/index_bank">รายการบัญชีธนาคาร</a>&nbsp;&nbsp;>&nbsp;&nbsp;
	เพิ่มบัญชีธนาคาร
</div>

<div id="showWarning" style="height:40px;"></div>

<div class="fluid">
	<iframe frameborder="0" width="0" height="0" id="myIframe" name="myIframe"></iframe>
	<form class="formElement" method="post" id="bank_form" name="bank_formAdd" target="myIframe" action="<?php echo DIR_ROOT?>shoppingcart/backend/add_bank">
        <div class="widget">
            <div class="formRow">
                <div class="grid2">
                    <label class="lbl fl" for="bank_name">ชื่อธนาคาร</label>
                    <span class="required"></span>
                </div>
                <div class="grid4">
                    <input type="text" id="bank_name" name="bank_name">
                </div>
            </div>
           	<div class="clear"></div>
            
            <div class="formRow">
                <div class="grid2">
                    <label class="lbl fl" for="bank_branch">สาขา</label>
                    <span class="required"></span>
                </div>
                <div class="grid4">
                    <input type="text" id="bank_branch" name="bank_branch">
                </div>
            </div>
           	<div class="clear"></div>
            
            <div class="formRow">
                <div class="grid2">
                    <label class="lbl fl" for="bank_account">ชื่อบัญชี</label>
                    <span class="required"></span>
                </div>
                <div class="grid3">
                    <input type="text" id="bank_account" name="bank_account">
                </div>
            </div>
           	<div class="clear"></div>
            
            <div class="formRow">
                <div class="grid2">
                    <label class="lbl fl" for="bank_no">เลขที่บัญชี</label>
                    <span class="required"></span>
                </div>
                <div class="grid3">
                    <input type="text" id="bank_no" name="bank_no">
                </div>
            </div>
           	<div class="clear"></div>            
            
            <div class="formRow">
                <div class="grid2">
                    <label class="lbl fl" for="bank_image">รูป</label>
                    <span class="required"></span>
                </div>
                <div class="grid2">
                    <input type="file" id="file_upload" name="file_upload">
                    <input type="hidden" name="image_path" id="image_path" />
                    <div id="wrap_img" style="text-align:center;" class="blank_img"><!--<img src="<?php echo DIR_PUBLIC?>images/icons/file/nofile.png" style="max-width:150px; max-height:150px;"/>--></div>
                    <div class="uploading" style="width:100px; height:100px; position:absolute; top:0px; display:none; "></div>
   				</div>
            </div>
           	<div class="clear" style="height:40px;"></div> 
            
            <div class="formRow">
                <div class="grid11">
                    <fieldset style="margin-top:20px; margin-bottom:20px;">
                        <legend>Setting</legend>
                        <div class="sep_bo"><label for='bank_publish'><input type="checkbox" id="bank_publish" name="bank_publish" value="1" checked="checked"/>&nbsp;&nbsp;<?php echo lang('web_publish');?></label></div>
                        <!--<div class="sep_bo"><label for='bank_pin'><input type="checkbox" id="bank_pin" name="bank_pin" value="1" />&nbsp;&nbsp;<?php echo lang('web_pin');?></label></div>-->
                    </fieldset>
                </div>
            </div>
           	<div class="clear"></div>
            
            <div class="formRow">
                <input type="hidden" id="captcha" name="captcha" value=""></input>
                <input type="submit" class="button" value="<?php echo lang('web_save');?>"></input>
            </div>
        </div>
	</form>
</div>
<style>
.uploadify,.uploadify-button,.swfupload{ margin-top:35px; }
#file_upload{position:absolute; bottom:0;left: 1px;width:100%;}
.uploadify-progress,.uploadify-progress-bar,.uploadify-queue{display: none;}
#wrap_img{ width:100px; height:100px; border:solid 1px #ccc; overflow:hidden; }
.blank_img{ background:center url("<?php echo DIR_PUBLIC?>images/icons/file/nofile_small.png") no-repeat; }
</style>
<script>
$(document).ready(function(){
	$("#bank_form").validate({
		rules: {
			'bank_name' : {
				required: true,
			},
			'bank_branch' : {
				required: true,
			},
			'bank_account' : {
				required: true,
			},
			'bank_no' : {
				required: true,
			},
		},
	   	submitHandler: function(form) {
			document.bank_formAdd.submit();
	 	}
	});
	$("#file_upload").uploadify({
		'buttonText':'Upload Image',
		'uploader' : DIR_ROOT+'shoppingcart/backend/upload_image/check_login/ignor',
		'width' : '98',
		'fileTypeExts' :  '*.gif; *.jpg; *.jpeg; *.png; *.tiff',
		'multi': false,
	    'onUploadStart' : function(){
			$('.uploading').show();
			$('#wrap_img').css('opacity',0.5);
		},
		'onUploadSuccess' : function(file, data, response) {
			$('.uploading').hide();
			$('#wrap_img').css('opacity',1);
			var src = $.trim(data);
			if(data=='') alert("ไฟล์ไม่รองรับค่ะ");
			else{
				// show img //
				var img = '<img src="'+DIR_ROOT+src+'" style="max-width:100px; max-height:100px;" />';
				var image_path = getInput('image_path');
				if(image_path != ''){
					$.post(DIR_ROOT+'shoppingcart/backend/delete_image',{image_path:image_path});
				}
				$("#wrap_img").html(img);
				$("#image_path").val(src);
			}
		}
	});
});

</script>
<?php }?>
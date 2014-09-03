<?php if(isset($redirect)){ echo $redirect; }else{ ?>

<h3><?php echo lang('slide_add');?></h3>
<div>
	<a href="<?php echo DIR_ROOT?>admin/admin/index">หน้าแรก</a>&nbsp;&nbsp;>&nbsp;&nbsp;
    <a href="<?php echo DIR_ROOT?>slide/backend/index"><?php echo lang('slide_ii');?></a>&nbsp;&nbsp;>&nbsp;&nbsp;
	<?php echo lang('slide_add');?>
</div>

<div id="showWarning" style="height:40px;"></div>

<div class="fluid">
	<iframe frameborder="0" width="0" height="0" id="myIframe" name="myIframe"></iframe>
	<form class="formElement" method="post" id="slide_form" name="slide_formAdd" target="myIframe" action="<?php echo DIR_ROOT?>slide/backend/add_slide">
        <div class="widget">
            <div class="formRow">
                <div class="grid2">
                    <label class="lbl fl" for="slide_name"><?php echo lang('slide_name');?></label>
                    <span class="required"></span>
                </div>
                <div class="grid5">
                    <input type="text" id="slide_name" name="slide_name">
                </div>
            </div>
           	<div class="clear"></div>         
            
            <div class="formRow">
                <div class="grid2">
                    <label class="lbl fl" for="slide_image"><?php echo lang('slide_image');?></label>
                    <span class="required"></span>
                </div>
                <div class="grid2">
                    <input type="file" id="file_upload" name="file_upload">
                    <input type="hidden" name="image_path" id="image_path" />
                    <div id="wrap_img" style="text-align:center;" class="blank_img"><!--<img src="<?php echo DIR_PUBLIC?>images/icons/file/nofile.png" style="max-width:150px; max-height:150px;"/>--></div>
                    <div class="uploading" style="width:300px; height:147px; position:absolute; top:0px; display:none; "></div>
   				</div>
                <div class="clear"></div>
                <div class="grid2">&nbsp;</div>
                <div class="grid5">
                    <div class="txt_notify" style="margin-top:40px;margin-left:-20px;">* ขนาดรูปที่แนะนำคือ 859 x 420 พิกเซล</div>
                </div>
            </div>
           	<div class="clear" style="height:40px;"></div> 
            
            <div class="formRow">
                <div class="grid11">
                    <fieldset style="margin-top:20px; margin-bottom:20px;">
                        <legend>Setting</legend>
                        <div class="sep_bo"><label for='slide_publish'><input type="checkbox" id="slide_publish" name="slide_publish" value="1" checked="checked"/>&nbsp;&nbsp;<?php echo lang('web_publish');?></label></div>
                        <div class="sep_bo"><label for='slide_pin'><input type="checkbox" id="slide_pin" name="slide_pin" value="1" />&nbsp;&nbsp;<?php echo lang('web_pin');?></label></div>
                    </fieldset>
                </div>
            </div>
           	<div class="clear"></div>
            
            <div class="formRow">
                <input type="hidden" id="captcha" name="captcha" value=""></input>
                <input type="submit" class="button" value="<?php echo lang('web_save');?>"></input>
            </div>
           	<div class="clear"></div>
        </div>
	</form>
</div>
<style>
.uploadify,.uploadify-button,.swfupload{ margin-top:35px; }
#file_upload{position:absolute; bottom:0;left: 1px;width:100%;}
.uploadify-progress,.uploadify-progress-bar,.uploadify-queue{display: none;}
#wrap_img{ width:300px; height:147px; border:solid 1px #ccc; overflow:hidden; }
.blank_img{ background:center url("<?php echo DIR_PUBLIC?>images/icons/file/nofile.png") no-repeat; }
</style>
<script>
$(document).ready(function(){
	$("#slide_form").validate({
		rules: {
			'slide_name' : {
				required: true,
			},
		},
	   	submitHandler: function(form) {
			document.slide_formAdd.submit();
	 	}
	});
	$("#file_upload").uploadify({
		'buttonText':'Upload Image',
		'uploader' : DIR_ROOT+'slide/backend/upload_image/check_login/ignor',
		'width' : '298',
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
				var img = '<img src="'+DIR_ROOT+src+'" style="max-width:300px; max-height:147px;" />';
				var image_path = getInput('image_path');
				if(image_path != ''){
					$.post(DIR_ROOT+'slide/backend/delete_image',{image_path:image_path});
				}
				$("#wrap_img").html(img);
				$("#image_path").val(src);
			}
		}
	});
	
});

</script>
<?php }?>
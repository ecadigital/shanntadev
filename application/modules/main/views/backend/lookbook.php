<?php if(isset($redirect)){ echo $redirect; }else{ ?>
<h3>หน้า Lookbook</h3>
<div>
	<a href="<?php echo DIR_ROOT?>admin/admin/index">หน้าแรก</a>&nbsp;&nbsp;>&nbsp;&nbsp;
	จัดการหน้าอื่นๆ&nbsp;&nbsp;>&nbsp;&nbsp;
	หน้า Lookbook
</div>

<div id="showWarning" style="height:40px;"></div>

<div class="fluid">
	<iframe frameborder="0" width="0" height="0" id="myIframe" name="myIframe"></iframe>
	<form class="formElement" method="post" id="main_form" name="main_formEdit" target="myIframe" action="<?php echo DIR_ROOT?>main/backend/lookbook">
        <div class="widget">
			
            <div class="formRow">
                <div class="grid2">
                    <label class="lbl fl" for="main_image">รูป</label>
                    <span class="required"></span>
                </div>
                <div class="grid2">
					<?php 
					$file_img = 'images/icons/file/nofile.png';
                    if(!empty($listEditMain['main_lookbook_path'])){
                        $file_img = 'upload/main/thumbnails/'.basename($listEditMain['main_lookbook_path']);
                    }
                    ?>
                    <input type="file" id="file_upload" name="file_upload">
                    <input type="hidden" name="image_path" id="image_path" />
                    <div id="wrap_img" style="text-align:center;" class="wrap_img"><img src="<?php echo DIR_PUBLIC.$file_img?>" style="max-width:300px; max-height:400px;"/></div>
                    <div class="uploading" id="uploading" style="width:300px; height:147px; position:absolute; top:0px; display:none; "></div>
   				</div>
                <div class="clear"></div>
                <div class="grid2">&nbsp;</div>
                <div class="grid5">
                    <div class="txt_notify" style="margin-top:40px;margin-left:-20px;">* ขนาดรูปที่แนะนำคือ --- พิกเซล</div>
                </div>
            </div>
           	<div class="clear" style="height:10px;"></div> 
			
            <div class="formRow">
                <input type="hidden" id="captcha" name="captcha" value=""></input>
                <input type="hidden" id="main_id" name="main_id" value="1"></input>
                <input type="submit" class="button" value="<?php echo lang('web_save');?>"></input>
			</div>
		</div>
	</form>
</div>
<style>
.uploadify,.uploadify-button,.swfupload{ margin-top:35px; }
#file_upload_banner{position:absolute; bottom:0;left: 1px;width:100%;}
#file_upload{position:absolute; bottom:0;left: 1px;width:100%;}
.uploadify-progress,.uploadify-progress-bar,.uploadify-queue{display: none;}
.wrap_img{ width:300px; height:400px; border:solid 1px #ccc; overflow:hidden; }
.blank_img{ background:center url("<?php echo DIR_PUBLIC?>images/icons/file/nofile.png") no-repeat; }
</style>
<script>
$(document).ready(function(){
	$("#file_upload").uploadify({
		'buttonText':'Upload Image',
		'uploader' : DIR_ROOT+'product/backend/upload_image/check_login/ignor',
		'width' : '298',
		'fileTypeExts' :  '*.gif; *.jpg; *.jpeg; *.png; *.tiff',
		'multi': false,
	    'onUploadStart' : function(){
			$('#uploading').show();
			$('#wrap_img').css('opacity',0.5);
		},
		'onUploadSuccess' : function(file, data, response) {
			$('#uploading').hide();
			$('#wrap_img').css('opacity',1);
			var src = $.trim(data);
			if(data=='') alert("ไฟล์ไม่รองรับค่ะ");
			else{
				// show img //
				var img = '<img src="'+DIR_ROOT+src+'" style="max-width:300px; max-height:400px;" />';
				var image_path = getInput('image_path');
				if(image_path != ''){
					$.post(DIR_ROOT+'product/backend/delete_image',{image_path:image_path});
				}
				$("#wrap_img").html(img);
				$("#image_path").val(src);
			}
		}
	});
});
</script>
<?php }?>
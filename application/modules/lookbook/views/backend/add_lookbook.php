<?php if(isset($redirect)){ echo $redirect; }else{ ?>

<h3>เพิ่ม LOOKBOOK</h3>
<div>
	<a href="<?php echo DIR_ROOT?>admin/admin/index">หน้าแรก</a>&nbsp;&nbsp;>&nbsp;&nbsp;
    <a href="<?php echo DIR_ROOT?>lookbook/backend/index"> LOOKBOOK</a>&nbsp;&nbsp;>&nbsp;&nbsp;
	เพิ่ม LOOKBOOK
</div>

<div id="showWarning" style="height:40px;"></div>

<div class="fluid">
	<iframe frameborder="0" width="0" height="0" id="myIframe" name="myIframe"></iframe>
	<form class="formElement" method="post" id="lookbook_form" name="lookbook_formAdd" target="myIframe" action="<?php echo DIR_ROOT?>lookbook/backend/add_lookbook">
        <div class="widget">
                     
	        <?php if(!empty($listAllLang)){foreach($listAllLang as $lang){
				$lang_icon = ($lang['language_icon'] != '')?'<img src="'.DIR_ROOT.$lang['language_icon'].'" title="'.$lang['language_desc'].'" style="margin-left:3px;" />':'';
				$lang_id = $lang['language_id'];
			?>
            <div class="formRow">
                <div class="grid2">
                    <label class="lbl fl" for="main_image">รูป <?php echo $lang_icon;?></label>
                    <span class="required"></span>
                </div>
                <div class="grid2">
					<?php 
					$file_img = 'images/icons/file/nofile.png';
                    if(!empty($listEditMain['lookbook_path'][$lang_id])){
                        $file_img = 'upload/lookbook/original/'.basename($listEditMain['lookbook_path'][$lang_id]);
                    }
                    ?>
                    <input type="file" class="file_upload" id="file_upload_<?php echo $lang_id?>" name="file_upload[<?php echo $lang_id;?>]">
                    <input type="hidden" name="image_path_<?php echo $lang_id;?>" id="image_path_<?php echo $lang_id;?>" />
                    <div id="wrap_img_<?php echo $lang_id;?>" style="text-align:center;" class="wrap_img"><img src="<?php echo DIR_PUBLIC.$file_img?>" style="max-width:726px; max-height:213px;"/></div>
                    <div class="uploading" id="uploading_<?php echo $lang_id;?>" style="width:726px; height:147px; position:absolute; top:0px; display:none; "></div>
   				</div>
                <div class="clear"></div>
                <div class="grid2">&nbsp;</div>
                <div class="grid5">
                    <div class="txt_notify" style="margin-top:40px;margin-left:-20px;">* ขนาดรูปที่แนะนำคือ 1,210x355 พิกเซล</div>
					<!-- 726 x 213 -->
                </div>
            </div>
           	<div class="clear" style="height:10px;"></div> 
			<?php }}?>
            
            <div class="formRow">
                <input type="hidden" id="captcha" name="captcha" value=""></input>
                <input type="submit" class="button" value="<?php echo lang('web_save');?>"></input>
            </div>
        </div>
	</form>
</div>
<style>
.uploadify,.uploadify-button,.swfupload{ margin-top:35px; }
#file_upload_banner{position:absolute; bottom:0;left: 1px;width:100%;}
#file_upload_1,#file_upload_2,#file_upload_3{position:absolute; bottom:5px;left: 1px;width:100%;}
.uploadify-progress,.uploadify-progress-bar,.uploadify-queue{display: none;}
.wrap_img{ width:726px; height:213px; border:solid 1px #ccc; overflow:hidden; }
.blank_img{ background:center url("<?php echo DIR_PUBLIC?>images/icons/file/nofile.png") no-repeat; }
</style>
<script>
$(document).ready(function(){
	<?php if(!empty($listAllLang)){foreach($listAllLang as $lang){
		$lang_id = $lang['language_id'];
		?>
		$("#file_upload_<?php echo $lang_id;?>").uploadify({
			'buttonText':'Upload Image',
			'uploader' : DIR_ROOT+'lookbook/backend/upload_image/check_login/ignor',
			'width' : '724',
			'fileTypeExts' :  '*.gif; *.jpg; *.jpeg; *.png; *.tiff',
			'multi': false,
			'onUploadStart' : function(){
				$('#uploading_<?php echo $lang_id;?>').show();
				$('#wrap_img_<?php echo $lang_id;?>').css('opacity',0.5);
			},
			'onUploadSuccess' : function(file, data, response) {
				$('#uploading_<?php echo $lang_id;?>').hide();
				$('#wrap_img_<?php echo $lang_id;?>').css('opacity',1);
				var src = $.trim(data);
				if(data=='') alert("ไฟล์ไม่รองรับค่ะ");
				else{
					// show img //
					var img = '<img src="'+DIR_ROOT+src+'" style="max-width:726px; max-height:213px;" />';
					var image_path = getInput('image_path_<?php echo $lang_id;?>');
					if(image_path != ''){
						$.post(DIR_ROOT+'lookbook/backend/delete_image',{image_path:image_path});
					}
					$("#wrap_img_<?php echo $lang_id;?>").html(img);
					$("#image_path_<?php echo $lang_id;?>").val(src);
				}
			}
		});
	<?php }}?>
});
</script>
<?php }?>
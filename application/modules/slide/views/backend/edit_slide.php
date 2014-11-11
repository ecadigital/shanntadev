<?php if(isset($redirect)){ echo $redirect; }else{ ?>
<h3><?php echo lang('slide_edit');?></h3>
<div>
	<a href="<?php echo DIR_ROOT?>admin/admin/index">หน้าแรก</a>&nbsp;&nbsp;>&nbsp;&nbsp;
    <a href="<?php echo DIR_ROOT?>slide/backend/index"><?php echo lang('slide_ii');?></a>&nbsp;&nbsp;>&nbsp;&nbsp;
	<?php echo lang('slide_edit');?>
</div>

<div id="showWarning" style="height:40px;"></div>

<div class="fluid">
	<iframe frameborder="0" width="0" height="0" id="myIframe" name="myIframe"></iframe>
	<form class="formElement" method="post" id="slide_form" name="slide_formEdit" target="myIframe" action="<?php echo DIR_ROOT?>slide/backend/edit_slide" enctype="multipart/form-data">
        <div class="widget">            
            <!--<div class="formRow">
                <div class="grid2">
                    <label class="lbl fl" for="slide_name"><?php echo lang('slide_name');?></label>
                    <span class="required"></span>
                </div>
                <div class="grid5">
                    <input type="text" id="slide_name" name="slide_name" value="<?php echo $listEditSlide['slide_name'];?>">
                </div>
            </div>
           	<div class="clear"></div>   -->         
            		
	        <?php if(!empty($listAllLang)){foreach($listAllLang as $lang){
				$lang_icon = ($lang['language_icon'] != '')?'<img src="'.DIR_ROOT.$lang['language_icon'].'" title="'.$lang['language_desc'].'" style="margin-left:3px;" />':'';
				$lang_id = $lang['language_id'];
				?>
				<div class="formRow">
					<div class="grid2">
						<label class="lbl fl" for="slide_keyhead[<?php echo $lang_id?>]">ข้อความหลัก <?php echo $lang_icon;?></label>
						<span class="required"></span>
					</div>
					<div class="grid4">
						<input type="text" id="slide_keyhead[<?php echo $lang_id?>]" name="slide_keyhead[<?php echo $lang_id?>]" value="<?php echo $listEditSlide['slide_keyhead'][$lang_id];?>">
					</div>
				</div>
				<div class="clear"></div>
				
				<div class="formRow">
					<div class="grid2">
						<label class="lbl fl" for="slide_keymessage[<?php echo $lang_id?>]">ข้อความรอง <?php echo $lang_icon;?></label>
						<span class="required"></span>
					</div>
					<div class="grid5">
						<textarea id="slide_keymessage[<?php echo $lang_id?>]" name="slide_keymessage[<?php echo $lang_id?>]" style="height:40px; width:389px;"><?php echo $listEditSlide['slide_keymessage'][$lang_id];?></textarea>
					</div>
				</div>
				<div class="clear" style="height:5px;"></div>
			<?php }}?>
            
			<div class="clear" style="height:5px;"></div>
            <div class="formRow">
                <div class="grid2">
                    <label class="lbl fl" for="slide_keymessage">ตำแหน่งการจัดข้อความ</label>
                </div>
                <div class="grid2">
					<div><input type="radio" name="slide_position" id="slide_positionL" value="L" <?php echo ($listEditSlide['slide_position']=='L') ? 'checked="checked"' : '';?> />&nbsp;&nbsp;<label for="slide_positionL">ซ้าย</label>&nbsp;&nbsp;&nbsp;&nbsp;
					<!--<input type="radio" name="slide_position" id="slide_positionC" value="C" />&nbsp;&nbsp;<label for="slide_positionC">กลาง</label>&nbsp;&nbsp;&nbsp;&nbsp;-->
					<input type="radio" name="slide_position" id="slide_positionR" value="R" <?php echo ($listEditSlide['slide_position']=='R') ? 'checked="checked"' : '';?> />&nbsp;&nbsp;<label for="slide_positionR">ขวา</label></div>
                </div>
                <div class="clear"></div>
                <div class="grid2">&nbsp;</div>
                <div class="grid5">
                    <div class="txt_notify" style="margin-left:-20px;">* เพื่อความสวยงาม ควรคำนึงถึงรูปที่ใช้ด้วย</div>
                </div>
            </div>   
           	<div class="clear" style="height:5px;"></div>
			
            <div class="formRow">
                <div class="grid2">
                    <label class="lbl fl" for="slide_image"><?php echo lang('slide_image');?></label>
                    <span class="required"></span>
                </div>
                <div class="grid2">
					<?php 
					$file_img = 'images/icons/file/nofile.png';
                    if(!empty($listEditSlide['slide_image'])){
                        $file_img = 'upload/slide/thumbnails/'.basename($listEditSlide['slide_image']);
                    }
                    ?>
                    <input type="file" id="file_upload" name="file_upload">
                    <input type="hidden" name="image_path" id="image_path" />
                    <div id="wrap_img" style="text-align:center;"><img src="<?php echo DIR_PUBLIC.$file_img?>" style="max-width:300px; max-height:147pxpx;"/></div>
                    <div class="uploading" style="width:300px; height:147px; position:absolute; top:0px; display:none; "></div>
            	</div>
                <div class="clear"></div>
                <div class="grid2">&nbsp;</div>
                <div class="grid5">
                    <div class="txt_notify" style="margin-top:40px;margin-left:-20px;">* ขนาดรูปที่แนะนำคือ 1,250 x 380 พิกเซล</div>
                </div>
            </div>
           	<div class="clear" style="height:40px;"></div> 
            
            <div class="formRow">   
                <input type="hidden" id="slide_id" name="slide_id" value="<?php echo $listEditSlide['slide_id'];?>"></input>
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
#wrap_img{ width:300px; height:147px; border:solid 1px #ccc; overflow:hidden;) no-repeat; }
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
			document.slide_formEdit.submit();
	 	}
	});
	$("#file_upload").uploadify({
		'buttonText':'Edit Image',
		'uploader' : DIR_ROOT+'slide/backend/upload_image/check_login/ignor',
		'width' : '298',
		'fileTypeExts' :  '*.gif; *.jpg; *.jpeg; *.png; *.tiff',
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
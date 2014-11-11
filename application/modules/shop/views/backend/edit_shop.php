<?php if(isset($redirect)){ echo $redirect; }else{ ?>
<script type="text/javascript" src="<?php echo DIR_PUBLIC?>js/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="<?php echo DIR_PUBLIC?>js/tiny_mce/load.js"></script>

<h3>แก้ไขข้อมูลตัวแทนจำหน่าย</h3>
<div>
	<a href="<?php echo DIR_ROOT?>admin/admin/index">Home</a>&nbsp;&nbsp;>&nbsp;&nbsp;
    <a href="<?php echo DIR_ROOT?>shop/backend/index">ข้อมูลตัวแทนจำหน่าย</a>&nbsp;&nbsp;>&nbsp;&nbsp;
	แก้ไขข้อมูลตัวแทนจำหน่าย
</div>

<div id="showWarning" style="height:40px;"></div>

<div class="fluid">
	<iframe frameborder="0" width="0" height="0" id="myIframe" name="myIframe"></iframe>
	<form class="formElement" method="post" id="shop_form" name="shop_formEdit" target="myIframe" action="<?php echo DIR_ROOT?>shop/backend/edit_shop">
        <div class="widget">
                        
            <div class="formRow" id="boxCol">
                <div class="grid2">
                    <label class="lbl fl" for="shop_image">รูป</label>
                    <span class="required"></span>
                </div>
                <div class="grid2">
                    <?php 
                    $img = '';
                    if(!empty($listEditShop['shop_image'])){
                        $file_img = 'upload/shop/thumbnails/'.basename($listEditShop['shop_image']);
                        $img = '<img src="'.DIR_PUBLIC.$file_img.'" style="max-width:300px; max-height:180px;"/>';
                    }
                    ?>
                    <input type="hidden" name="image_path" id="image_path" />
                    <div id="wrap_img" style="text-align:center;" class="wrap_img"><?php echo $img;?></div>
                    <div id="uploading" class="uploading" style="width:300px; height:180px; position:absolute; top:0px; display:none; "></div>
                    <input type="file" id="shop_file_upload" name="shop_file_upload">
                    <!--<div class="txt_notify" style="width:500px; margin-top:7px;">* ขนาดรูปภาพที่แนะนำคือ 1400 x 749 พิกเซล</div>-->
                </div>
            </div>
            <div class="clear"></div>       
            
	        <?php if(!empty($listAllLang)){foreach($listAllLang as $lang){
				$lang_icon = ($lang['language_icon'] != '')?'<img src="'.DIR_ROOT.$lang['language_icon'].'" title="'.$lang['language_desc'].'" style="margin-left:3px;" />':'';
				$lang_id = $lang['language_id'];
			?>
			<div class="formRow">
                <div class="grid12">
                    <fieldset>
                        <legend><?php echo $lang['language_desc'].$lang_icon;?></legend>
                        
                        <div class="formRow">
                            <div class="grid2">
                                <label class="lbl fl" for="shop_name[<?php echo $lang_id?>]">ชื่อตัวแทนจำหน่าย</label>
                                <span class="required"></span>
                            </div>
                            <div class="grid5">
                                <input type="text" id="shop_name[<?php echo $lang_id?>]" name="shop_name[<?php echo $lang_id?>]" value="<?php echo $listEditShop['shop_name'][$lang_id];?>" >
                            </div>
                        </div>
                        <div class="clear"></div>
                        
                        <div class="formRow">
                            <div class="grid2">
                                <label class="lbl fl" for="shop_detail[<?php echo $lang_id?>]">รายละเอียด</label>
                            </div>
                            <div class="grid9">
                                <textarea id="shop_detail[<?php echo $lang_id?>]" name="shop_detail[<?php echo $lang_id?>]" style="width:300px; height:100px;"><?php echo $listEditShop['shop_detail'][$lang_id];?></textarea>
                            </div>
                        </div>
                        <div class="clear" style="height:10px;"></div>
                    </fieldset>
                </div>
            </div>
            <div class="clear" style="height:10px;"></div>
            <?php }}?>
            
            <div class="formRow">   
                <input type="hidden" id="shop_id" name="shop_id" value="<?php echo $listEditShop['shop_id'];?>"></input>
                <input type="hidden" id="captcha" name="captcha" value=""></input>
                <input type="submit" class="button" value="<?php echo lang('web_save');?>"></input>
            </div>
    </form>
</div>
<style>
div#boxCol .uploadify,div#boxCol .uploadify-button,.swfupload{ margin-top:0px; }
div#boxCol #file_upload{position:absolute; bottom:0;left: 1px;width:100%;}
div#boxCol .uploadify-progress,div#boxCol .uploadify-progress-bar,div#boxCol .uploadify-queue{display: none;}
div#boxCol .wrap_img{ width:300px; height:180px; border:solid 1px #ccc; overflow:hidden; }
div#boxCol .blank_img{ background:center url("<?php echo DIR_PUBLIC?>images/icons/file/nofile.png") no-repeat; }

.uploadify,.uploadify-button,.swfupload{ margin-top:0px; }
#file_upload{position:absolute; bottom:0;left: 1px;width:100%;}
.uploadify-progress,.uploadify-progress-bar,.uploadify-queue{display: none;}
.wrap_img{ width:300px; height:180px; border:solid 1px #ccc; overflow:hidden; }
.blank_img{ background:center url("<?php echo DIR_PUBLIC?>images/icons/file/nofile.png") no-repeat; }
</style>
<script>
$(document).ready(function(){
	$("#shop_form").validate({
		rules: {
			<?php if(!empty($listAllLang)){foreach($listAllLang as $lang){?>
			'shop_name[<?php echo $lang['language_id']?>]' : {
				required: true,
			},
			<?php }}?>
		},
	   	submitHandler: function(form) {
			document.shop_formEdit.submit();
	 	}
	});
   // LoadTinyMCE();
	$("#shop_file_upload").uploadify({
		'buttonText':'Upload Image',
		'uploader' : DIR_ROOT+'shop/backend/upload_image/check_login/ignor',
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
				var img = '<img src="'+DIR_ROOT+src+'" style="max-width:300px; max-height:250px;" />';
				var image_path = getInput('image_path');
				if(image_path != ''){
					$.post(DIR_ROOT+'shop/backend/delete_image',{image_path:image_path});
				}
				$("#wrap_img").html(img);
				$("#image_path").val(src);
			}
		}
	});
});
</script>
<?php }?>
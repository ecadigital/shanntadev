<?php if(isset($redirect)){ echo $redirect; }else{ ?>
<h3>แก้ไขข้อมูลหมวดหมู่คอลเลคชั่น</h3>
<div>
	<a href="<?php echo DIR_ROOT?>admin/admin/index">หน้าแรก</a>&nbsp;&nbsp;>&nbsp;&nbsp;
    <a href="<?php echo DIR_ROOT?>collection/backend/index">รายการคอลเลคชั่น</a>&nbsp;&nbsp;>&nbsp;&nbsp;
    <a href="<?php echo DIR_ROOT?>collection/backend/index_categories">รายการหมวดหมู่คอลเลคชั่น</a>&nbsp;&nbsp;>&nbsp;&nbsp;
	แก้ไขข้อมูลหมวดหมู่คอลเลคชั่น
</div>

<div id="showWarning" style="height:40px;"></div>

<div class="fluid">
	<iframe frameborder="0" width="0" height="0" id="myIframe" name="myIframe"></iframe>
	<form class="formElement" method="post" id="collection_categories_form" name="collection_categories_formEdit" target="myIframe" action="<?php echo DIR_ROOT?>collection/backend/edit_categories">
        <div class="widget">
            <!--<div class="formRow">
                <div class="grid2">
                    <label class="lbl" for="collection_categories_parent_id"><?php echo lang('web_parent');?></label>
                    <span class="required"></span>
                </div>
                <div class="grid3">                    
                    <select id="collection_categories_parent_id" name="collection_categories_parent_id" class="sep_bo">
                    	<option value="0">--</option>
                        <?php 
						if(!empty($listCategoriesParent)){
							foreach($listCategoriesParent as $list){
                        		echo '<option value="'.$list["collection_categories_id"].'" '; echo ($list["collection_categories_id"] == $listEditCategories['collection_categories_parent_id'])?'selected="selected"':''; echo '>'.$list["collection_categories_name"].'</option>';
							}
						}
						?>
                    </select>
                </div>
            </div>
            <div class="clear"></div>-->
            
	        <?php if(!empty($listAllLang)){foreach($listAllLang as $lang){
				$lang_icon = ($lang['language_icon'] != '')?'<img src="'.DIR_ROOT.$lang['language_icon'].'" title="'.$lang['language_desc'].'" style="margin-left:3px;" />':'';
				$lang_id = $lang['language_id'];
			?>            
				<div class="formRow">
					<div class="grid2">
						<label class="lbl fl" for="collection_categories_name[<?php echo $lang_id?>]">ชื่อหมวดหมู่คอลเลคชั่น <?php echo $lang_icon;?></label>
						<?php if($lang_id==1) echo '<span class="required"></span>';?>
					</div>
					<div class="grid3">
						<input type="text" id="collection_categories_name[<?php echo $lang_id?>]" name="collection_categories_name[<?php echo $lang_id?>]" value="<?php echo $listEditCategories['collection_categories_name'][$lang_id];?>" >
					</div>
				</div>
				<div class="clear"></div>
			<?php }}?>
			
            <hr/>
           	<div class="clear"></div> 
            
			<h4>แบนเนอร์หน้าแรก</h4>
			
	        <?php if(!empty($listAllLang)){foreach($listAllLang as $lang){
				$lang_icon = ($lang['language_icon'] != '')?'<img src="'.DIR_ROOT.$lang['language_icon'].'" title="'.$lang['language_desc'].'" style="margin-left:3px;" />':'';
				$lang_id = $lang['language_id'];
			?>			
				<div class="formRow">
					<div class="grid2">
						<label class="lbl fl" for="collection_categories_home_keyhead[<?php echo $lang_id?>]">ข้อความหลัก <?php echo $lang_icon;?></label>
					</div>
					<div class="grid4">
						<input type="text" id="collection_categories_home_keyhead[<?php echo $lang_id?>]" name="collection_categories_home_keyhead[<?php echo $lang_id?>]" value="<?php echo $listEditCategories['collection_categories_home_keyhead'][$lang_id];?>">
					</div>
				</div>   
				<div class="clear"></div>
				<div class="formRow">
					<div class="grid2">
						<label class="lbl fl" for="collection_categories_home_keymessage[<?php echo $lang_id?>]">ข้อความรอง <?php echo $lang_icon;?></label>
					</div>
					<div class="grid4">
						<textarea id="collection_categories_home_keymessage[<?php echo $lang_id?>]" name="collection_categories_home_keymessage[<?php echo $lang_id?>]" style="height:40px; width:389px;"><?php echo $listEditCategories['collection_categories_home_keymessage'][$lang_id];?></textarea>
					</div>
				</div>   
				<div class="clear" style="height:5px;"></div>
			<?php }}?>
			
            <div class="formRow">
                <div class="grid2">
                    <label class="lbl fl" for="collection_categories_image_home">รูปแบนเนอร์หน้าแรก</label>
                    <span class="required"></span>
                </div>
                <div class="grid2">
					<?php 
					$file_img = 'images/icons/file/nofile.png';
                    if(!empty($listEditCategories['collection_categories_home_path'])){
                        $file_img = 'upload/collection/thumbnails/'.basename($listEditCategories['collection_categories_home_path']);
                    }
                    ?>
                    <input type="file" id="file_upload_home" name="file_upload_home">
                    <input type="hidden" name="image_path_home" id="image_path_home" />
                    <div id="wrap_img_home" style="text-align:center;" class="wrap_img"><img src="<?php echo DIR_PUBLIC.$file_img?>" style="max-width:300px; max-height:147pxpx;"/></div>
                    <div class="uploading" id="uploading_home" style="width:300px; height:147px; position:absolute; top:0px; display:none; "></div>
   				</div>
                <div class="clear"></div>
                <div class="grid2">&nbsp;</div>
                <div class="grid5">
                    <div class="txt_notify" style="margin-top:40px;margin-left:-20px;">* ขนาดรูปที่แนะนำคือ 859 x 420 พิกเซล</div>
                </div>
            </div>
           	<div class="clear" style="height:10px;"></div> 
            <hr/>
           	<div class="clear"></div> 
            
			<!--<h4>แบนเนอร์หน้าคอลเลคชั่น</h4>-->	
			
	        <?php if(!empty($listAllLang)){foreach($listAllLang as $lang){
				$lang_icon = ($lang['language_icon'] != '')?'<img src="'.DIR_ROOT.$lang['language_icon'].'" title="'.$lang['language_desc'].'" style="margin-left:3px;" />':'';
				$lang_id = $lang['language_id'];
			?>	
				<div class="formRow">
					<div class="grid2">
						<label class="lbl fl" for="collection_categories_image_banner_<?php echo $lang_id;?>">รูปแบนเนอร์หน้าคอลเลคชั่น <?php echo $lang_icon;?></label>
						<span class="required"></span>
					</div>
					<div class="grid2">
						<?php 
						$file_img = 'images/icons/file/nofile.png';
						if(!empty($listEditCategories['collection_categories_banner_path'][$lang_id])){
							$file_img = 'upload/collection/original/'.basename($listEditCategories['collection_categories_banner_path'][$lang_id]);
						}
						?>
						<input type="file" id="file_upload_banner_<?php echo $lang_id;?>" name="file_upload_banner_<?php echo $lang_id;?>">
						<input type="hidden" name="image_path_banner_<?php echo $lang_id;?>" id="image_path_banner_<?php echo $lang_id;?>" />
						<div id="wrap_img_banner_<?php echo $lang_id;?>" style="text-align:center;" class="wrap_img_banner"><img src="<?php echo DIR_PUBLIC.$file_img?>" style="max-width:726px; max-height:147px;"/></div>
						<div class="uploading" id="uploading_banner_<?php echo $lang_id;?>" style="width:726px !important; height:147px; position:absolute; top:0px; display:none; "></div>
					</div>
					<div class="clear"></div>
					<div class="grid2">&nbsp;</div>
					<div class="grid5">
						<div class="txt_notify" style="margin-top:40px;margin-left:-20px;">* ขนาดรูปที่แนะนำคือ 1,210x355 พิกเซล</div>
					</div>
				</div>
				<div class="clear" style="height:40px;"></div> 
			<?php }}?>
			
			
            <div class="formRow">
                <input type="hidden" id="captcha" name="captcha" value=""></input>
                <input type="hidden" id="collection_categories_id" name="collection_categories_id" value="<?php echo $listEditCategories['collection_categories_id']?>"></input>
                <input type="submit" class="button" value="<?php echo lang('web_save');?>"></input>
			</div>
		</div>
	</form>
</div>
<style>
.uploadify,.uploadify-button,.swfupload{ margin-top:35px; }
#file_upload_banner_1,#file_upload_banner_2,#file_upload_banner_3{position:absolute; bottom:0;left: 1px;width:100%;}
#file_upload_home{position:absolute; bottom:0;left: 1px;width:100%;}
.uploadify-progress,.uploadify-progress-bar,.uploadify-queue{display: none;}
.wrap_img{ width:300px; height:147px; border:solid 1px #ccc; overflow:hidden; }
.wrap_img_banner{ width:726px; height:147px; border:solid 1px #ccc; overflow:hidden; }
.blank_img{ background:center url("<?php echo DIR_PUBLIC?>images/icons/file/nofile.png") no-repeat; }
</style>
<script>
$(document).ready(function(){
	$("#collection_categories_form").validate({
		rules: {
			'collection_categories_name[1]' : {
				required: true,
			},
	   },
	   submitHandler: function(form) {
			document.collection_categories_formEdit.submit();
		}
	});
	$("#file_upload_home").uploadify({
		'buttonText':'Upload Image',
		'uploader' : DIR_ROOT+'collection/backend/upload_image/check_login/ignor',
		'width' : '298',
		'fileTypeExts' :  '*.gif; *.jpg; *.jpeg; *.png; *.tiff',
		'multi': false,
	    'onUploadStart' : function(){
			$('#uploading_home').show();
			$('#wrap_img_home').css('opacity',0.5);
		},
		'onUploadSuccess' : function(file, data, response) {
			$('#uploading_home').hide();
			$('#wrap_img_home').css('opacity',1);
			var src = $.trim(data);
			if(data=='') alert("ไฟล์ไม่รองรับค่ะ");
			else{
				// show img //
				var img = '<img src="'+DIR_ROOT+src+'" style="max-width:300px; max-height:147px;" />';
				var image_path = getInput('image_path_home');
				if(image_path != ''){
					$.post(DIR_ROOT+'collection/backend/delete_image_home',{image_path:image_path});
				}
				$("#wrap_img_home").html(img);
				$("#image_path_home").val(src);
			}
		}
	});
	<?php if(!empty($listAllLang)){foreach($listAllLang as $lang){
		$lang_id = $lang['language_id'];
		?>
		$("#file_upload_banner_<?php echo $lang_id;?>").uploadify({
			'buttonText':'Upload Image',
			'uploader' : DIR_ROOT+'collection/backend/upload_image/check_login/ignor',
			'width' : '724',
			'fileTypeExts' :  '*.gif; *.jpg; *.jpeg; *.png; *.tiff',
			'multi': false,
			'onUploadStart' : function(){
				$('#uploading_banner_<?php echo $lang_id;?>').show();
				$('#wrap_img_banner_<?php echo $lang_id;?>').css('opacity',0.5);
			},
			'onUploadSuccess' : function(file, data, response) {
				$('#uploading_banner_<?php echo $lang_id;?>').hide();
				$('#wrap_img_banner_<?php echo $lang_id;?>').css('opacity',1);
				var src = $.trim(data);
				if(data=='') alert("ไฟล์ไม่รองรับค่ะ");
				else{
					// show img //
					var img = '<img src="'+DIR_ROOT+src+'" style="max-width:726px; max-height:213px;" />';
					var image_path = getInput('image_path_banner_<?php echo $lang_id;?>');
					if(image_path != ''){
						$.post(DIR_ROOT+'collection/backend/delete_image_banner',{image_path:image_path});
					}
					$("#wrap_img_banner_<?php echo $lang_id;?>").html(img);
					$("#image_path_banner_<?php echo $lang_id;?>").val(src);
				}
			}
		});
	<?php }}?>
});
</script>
<?php }?>
<?php if(isset($redirect)){ echo $redirect; }else{ ?>
<script type="text/javascript" src="<?php echo DIR_PUBLIC?>js/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="<?php echo DIR_PUBLIC?>js/tiny_mce/load.js"></script>

<h3>แก้ไข Jewely D.I.Y</h3>
<div>
	<a href="<?php echo DIR_ROOT?>admin/admin/index">หน้าแรก</a>&nbsp;&nbsp;>&nbsp;&nbsp;
    <a href="<?php echo DIR_ROOT?>jewely/backend/index"> Jewely D.I.Y</a>&nbsp;&nbsp;>&nbsp;&nbsp;
	แก้ไข Jewely D.I.Y
</div>

<div id="showWarning" style="height:40px;"></div>

<div class="fluid">
	<iframe frameborder="0" width="0" height="0" id="myIframe" name="myIframe"></iframe>
	<form class="formElement" method="post" id="jewely_form" name="jewely_formEdit" target="myIframe" action="<?php echo DIR_ROOT?>jewely/backend/edit_jewely">
        <div class="widget">   
            
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
								<label class="lbl fl" for="jewely_name[<?php echo $lang_id?>]">หัวข้อ</label>
								<?php if($lang_id==1) echo '<span class="required"></span>'; ?>
							</div>
							<div class="grid5">
								<input type="text" id="jewely_name[<?php echo $lang_id?>]" name="jewely_name[<?php echo $lang_id?>]" value="<?php echo $listEditJewely['jewely_name'][$lang_id];?>">
							</div>
						</div>
						<div class="clear"></div>
						
						<div class="formRow">
							<div class="grid2">
								<label class="lbl fl" for="jewely_detail[<?php echo $lang_id?>]">รายละเอียด</label>
							</div>
							<div class="grid9">
								<textarea id="jewely_detail[<?php echo $lang_id?>]" name="jewely_detail[<?php echo $lang_id?>]" class="mceEditor"><?php echo $listEditJewely['jewely_detail'][$lang_id];?></textarea>
							</div>
						</div>
						<div class="clear" style="height:10px;"></div>
            
                    </fieldset>
                </div>
            </div>
            <div class="clear" style="height:10px;"></div>
            <?php }}?>
            
            <div class="formRow">
                <div class="grid11">            
                    <fieldset style="margin-top:20px;">
                        <legend><?php echo lang('web_image');?></legend>
                        <input type="file" id="file_upload" name="file_upload">
                        <?php if(!empty($listEditJewely['jewely_images'])){?>
                        <ul id="UploadQueue" class="hidden">
                            <?php foreach($listEditJewely['jewely_images'] as $index=>$jewely_images){?>
                            <li class="queue" id="EditUpload_0_<?php echo $index?>" data-itemid="<?php echo $jewely_images['jewely_images_id'];?>"><?php echo $jewely_images['jewely_images_path'];?></li>
                            <?php }?>
                        </ul>
                        <?php }?>
                        <div class="txt_notify">* <?php echo lang('web_notify_multi_upload');?>&nbsp;&nbsp;/&nbsp;&nbsp; ขนาดรูปที่แนะนำคือ 410 x 372 พิกเซล</div>
                    </fieldset>
                </div>
            </div>
           	<div class="clear" style="height:10px;"></div>
            
            <div class="formRow">   
                <input type="hidden" id="jewely_id" name="jewely_id" value="<?php echo $listEditJewely['jewely_id'];?>"></input>
                <input type="hidden" id="captcha" name="captcha" value=""></input>
                <input type="submit" class="button" value="<?php echo lang('web_save');?>"></input>
            </div>
    </form>
</div>

<script>
$(document).ready(function(){
	$("#jewely_form").validate({
		rules: {
			'jewely_name[1]' : {
				required: true,
			},
		},
	   	submitHandler: function(form) {
			document.jewely_formEdit.submit();
	 	}
	});
    $("#file_upload").uploadfile({ module:"jewely" });
    LoadTinyMCE();
});
</script>
<?php }?>
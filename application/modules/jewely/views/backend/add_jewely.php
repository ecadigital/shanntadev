<?php if(isset($redirect)){ echo $redirect; }else{ ?>
<script type="text/javascript" src="<?php echo DIR_PUBLIC?>js/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="<?php echo DIR_PUBLIC?>js/tiny_mce/load.js"></script>

<h3>เพิ่ม Jewely D.I.Y</h3>
<div>
	<a href="<?php echo DIR_ROOT?>admin/admin/index">หน้าแรก</a>&nbsp;&nbsp;>&nbsp;&nbsp;
    <a href="<?php echo DIR_ROOT?>jewely/backend/index"> Jewely D.I.Y</a>&nbsp;&nbsp;>&nbsp;&nbsp;
	เพิ่ม Jewely D.I.Y
</div>

<div id="showWarning" style="height:40px;"></div>

<div class="fluid">
	<iframe frameborder="0" width="0" height="0" id="myIframe" name="myIframe"></iframe>
	<form class="formElement" method="post" id="jewely_form" name="jewely_formAdd" target="myIframe" action="<?php echo DIR_ROOT?>jewely/backend/add_jewely">
        <div class="widget">
                        
            <div class="formRow">
                <div class="grid2">
                    <label class="lbl fl" for="jewely_name">หัวข้อ</label>
                    <span class="required"></span>
                </div>
                <div class="grid5">
                    <input type="text" id="jewely_name" name="jewely_name">
                </div>
            </div>
           	<div class="clear"></div>
            
            <div class="formRow">
                <div class="grid2">
                    <label class="lbl fl" for="jewely_detail">รายละเอียด</label>
                </div>
                <div class="grid9">
                    <textarea id="jewely_detail" name="jewely_detail" class="mceEditor"></textarea>
                </div>
            </div>
           	<div class="clear" style="height:10px;"></div>
            
            <div class="formRow">
                <div class="grid11">
                    <fieldset style="margin-top:20px;">
                        <legend><?php echo lang('web_image');?></legend>
                        <input type="file" id="file_upload" name="file_upload">
                        <div class="txt_notify">* <?php echo lang('web_notify_multi_upload');?></label></div>
                    </fieldset>
        		</div>
   			</div>
           	<div class="clear" style="height:10px;"></div>
            
            <div class="formRow">
                <input type="hidden" id="captcha" name="captcha" value=""></input>
                <input type="submit" class="button" value="<?php echo lang('web_save');?>"></input>
            </div>
        </div>
	</form>
</div>
<script>
$(document).ready(function(){
	$("#jewely_form").validate({
		rules: {
			'jewely_name' : {
				required: true,
			},
		},
	   	submitHandler: function(form) {
			document.jewely_formAdd.submit();
	 	}
	});
    $("#file_upload").uploadfile({ module:"jewely" });
    LoadTinyMCE();
	
});

</script>
<?php }?>
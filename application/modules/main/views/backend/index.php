<?php if(isset($redirect)){ echo $redirect; }else{ ?>
<script type="text/javascript" src="<?php echo DIR_PUBLIC?>js/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="<?php echo DIR_PUBLIC?>js/tiny_mce/load.js"></script>
<?php
$name = '';
$input_name = '';
if($p==1){ $name = "แก้ไขข้อมูลหน้าติดต่อ"; 				$input_name = "main_contact";}
else if($p==2){ $name = "หน้าแรก: วิธีการซื้อขาย"; 		$input_name = "main_home_howtobuy";}
else if($p==3){ $name = "หน้าแรก: รู้จัก Have Reward"; $input_name = "main_home_havereward";}
else if($p==4){ $name = "หน้าแรก: Voucher คืออะไร";	$input_name = "main_voucher";}
else if($p==5){ $name = "หน้าแรก: วิธีแลก Voucher";	$input_name = "main_howtoget_voucher";}
else if($p==6) $name = "Footer: ติดต่อสอบถาม";		
else if($p==7){ $name = "Footer: หน้าเติมแต้ม";			$input_name = "main_point";}
else if($p==8){ $name = "Footer: หน้าวิธีแลกแต้ม";		$input_name = "main_howtoget_point";}
else if($p==9){ $name = "หน้าแรก: Banner ธนาคาร";		$input_name = "main_bank_path";}
else if($p==10){ $name = "หน้าแรก: ขั้นตอนการโอนเงิน";		$input_name = "main_howto_payment";}
?>
<h3><?php echo $name;//lang($name.'_edit');?></h3>
<div>
	<a href="<?php echo DIR_ROOT?>admin/admin/index">หน้าแรก</a>&nbsp;&nbsp;>&nbsp;&nbsp;
    <a href="<?php echo DIR_ROOT?>main/backend/index"><?php echo lang('main_ii');?></a>&nbsp;&nbsp;>&nbsp;&nbsp;
	<?php echo $name;//lang($name.'_edit');?>
</div>

<div id="showWarning" style="height:40px;"></div>

<div class="fluid">
	<iframe frameborder="0" width="0" height="0" id="myIframe" name="myIframe"></iframe>
	<form class="formElement" method="post" id="main_form" name="main_formEdit" target="myIframe" action="<?php echo DIR_ROOT?>main/backend/index" enctype="multipart/form-data">
        <div class="widget">      
        
            <?php if($p<=8 && $p!=6){?>        
                <div class="formRow">
                    <div class="grid2">
                        <label class="lbl fl" for="<?php echo $input_name;?>"><?php echo 'รายละเอียด';//lang($name);?></label>
                    </div>
                    <div class="grid9">
                        <textarea id="<?php echo $input_name;?>" name="<?php echo $input_name;?>" class="mceEditor"><?php echo $listEditMain[$input_name];?></textarea>
                    </div>
                </div>
                
                <div class="clear" style="height:10px;"></div>
            <?php }?>
            
            <?php if($p==1){?>        
                <div class="formRow">
                    <div class="grid2">
                        <label class="lbl fl" for="main_latitude"><?php echo lang('main_latitude');?></label>
                    </div>
                    <div class="grid3">
                        <input type="text" id="main_latitude" name="main_latitude" value="<?php echo $listEditMain['main_latitude'];?>" />
                    </div>
                </div>
                <div class="clear"></div>   
                       
                <div class="formRow">
                    <div class="grid2">
                        <label class="lbl fl" for="main_longitude"><?php echo lang('main_longitude');?></label>
                    </div>
                    <div class="grid3">
                        <input type="text" id="main_longitude" name="main_longitude" value="<?php echo $listEditMain['main_longitude'];?>" />
                    </div>
                </div>
           		<div class="clear" style="height:10px;"></div>
			<?php }?>
        
            <?php if($p==6){?>        
                <div class="formRow">
                    <div class="grid2">
                        <label class="lbl fl" for="main_tel">เบอร์โทรศัพท์</label>
                    </div>
                    <div class="grid3">
                        <input type="text" id="main_tel" name="main_tel" value="<?php echo $listEditMain['main_tel'];?>" />
                    </div>
                </div>       
                <div class="formRow">
                    <div class="grid2">
                        <label class="lbl fl" for="main_email">อีเมล์</label>
                    </div>
                    <div class="grid3">
                        <input type="text" id="main_email" name="main_email" value="<?php echo $listEditMain['main_email'];?>" />
                    </div>
                </div>       
                <div class="formRow">
                    <div class="grid2">
                        <label class="lbl fl" for="main_facebook">Facebook</label>
                    </div>
                    <div class="grid9">
                        http://www.facebook.com/<input type="text" id="main_facebook" name="main_facebook" value="<?php echo $listEditMain['main_facebook'];?>" style="width:143px;" />
                    </div>
                </div>       
                <div class="formRow">
                    <div class="grid2">
                        <label class="lbl fl" for="main_twitter">ทวิตเตอร์</label>
                    </div>
                    <div class="grid9">
                        http://www.twitter.com/<input type="text" id="main_twitter" name="main_twitter" value="<?php echo $listEditMain['main_twitter'];?>" style="width:162px;" />
                    </div>
                </div>
                
                <div class="clear" style="height:10px;"></div>
            <?php }?>
            
            <?php if($p==9){?>        
                <div class="formRow">
                    <div class="grid2">
                        <label class="lbl fl" for="file_upload">ฺBanner ธนาคาร</label>
                    </div>
                    <div class="grid5">
						<?php 
                        $file_img = 'images/icons/file/nofile.png';
                        if(!empty($listEditMain['main_bank_path'])){
                            $file_img = 'upload/main/original/'.basename($listEditMain['main_bank_path']);
                        }
                        ?>
                        <input type="file" id="file_upload" name="file_upload">
                        <input type="hidden" name="image_path" id="image_path" />
                        <div id="wrap_img" style="text-align:center;"><img src="<?php echo DIR_PUBLIC.$file_img?>" style="max-width:254px; max-height:400px;"/></div>
                        <div class="uploading" style="width:254px; height:400px; position:absolute; top:0px; display:none; "></div>
                    </div>
                    <div class="clear"></div>
                    <div class="grid2">&nbsp;</div>
                    <div class="grid5">
                    	<div class="txt_notify" style="margin-top:40px;margin-left:-20px;">* ความกว้างที่แนะนำคือ 254 พิกเซล</div>
                    </div>
                </div>
                <div class="clear" style="height:20px;"></div> 
                  
                <div class="formRow">
                    <div class="grid2">
                        <label class="lbl fl" for="main_howto_payment"><?php echo 'ขั้นตอนการโอนเงิน';//lang($name);?></label>
                    </div>
                    <div class="grid9">
                        <textarea id="main_howto_payment" name="main_howto_payment" class="mceEditor"><?php echo $listEditMain['main_howto_payment'];?></textarea>
                    </div>
                </div>
                <div class="clear" style="height:10px;"></div> 
                  
			<?php }?>
            
            <?php /*?><?php if($p==10){?>        
                <div class="formRow">
                    <div class="grid2">
                        <label class="lbl fl" for="file_upload">ขั้นตอนการโอนเงิน</label>
                    </div>
                    <div class="grid5">
						<?php 
                        $file_img = 'images/icons/file/nofile.png';
                        if(!empty($listEditMain['main_howto_payment'])){
                            $file_img = 'upload/main/original/'.basename($listEditMain['main_howto_payment']);
                        }
                        ?>
                        <input type="file" id="file_upload" name="file_upload">
                        <input type="hidden" name="image_path" id="image_path" />
                        <div id="wrap_img" style="text-align:center;"><img src="<?php echo DIR_PUBLIC.$file_img?>" style="max-width:254px; max-height:400px;"/></div>
                        <div class="uploading" style="width:254px; height:400px; position:absolute; top:0px; display:none; "></div>
                    </div>
                    <div class="clear"></div>
                    <div class="grid2">&nbsp;</div>
                    <div class="grid5">
                    	<div class="txt_notify" style="margin-top:40px;margin-left:-20px;">* ความกว้างที่แนะนำคือ 254 พิกเซล</div>
                    </div>
                </div>
                <div class="clear" style="height:50px;"></div>
			<?php }?><?php */?>
            
            <div class="formRow">   
                <input type="hidden" id="p" name="p" value="<?php echo $p;?>"></input>
                <input type="hidden" id="captcha" name="captcha" value=""></input>
                <input type="submit" class="button" value="<?php echo lang('web_save');?>"></input>
            </div>
    </form>
</div>

<style>
.uploadify,.uploadify-button,.swfupload{ margin-top:35px;width:250px !important;  }
#file_upload{position:absolute; bottom:0;left: 1px;width:100%;}
.uploadify-progress,.uploadify-progress-bar,.uploadify-queue{display: none;}
#wrap_img{ width:254px; height:400px; border:solid 1px #ccc; overflow:hidden; }
.blank_img{ background:center url("<?php echo DIR_PUBLIC?>images/icons/file/nofile_small.png") no-repeat; }
</style>

<script>
$(document).ready(function(){
	$("#main_form").validate({
		rules: {
			'<?php echo $name;?>' : {
				required: true,
			},
		},
	   	submitHandler: function(form) {
			document.main_formEdit.submit();
	 	}
	});
    //$("#file_upload").uploadfile({ module:"main" });
	$("#file_upload").uploadify({
		'buttonText':'Upload Image',
		'uploader' : DIR_ROOT+'main/backend/upload_image/check_login/ignor',
		'width' : '250',
		'fileTypeExts' :  '*.gif; *.jpg; *.jpeg; *.png; *.tiff',
		'multi': false,
		'module':"main",
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
				var img = '<img src="'+DIR_ROOT+src+'" style="max-width:254px; max-height:400px;" />';
				var image_path = getInput('image_path');
				if(image_path != ''){
					$.post(DIR_ROOT+'main/backend/delete_image',{image_path:image_path, p:'<?php echo $p;?>'});
				}
				$("#wrap_img").html(img);
				$("#image_path").val(src);
			}
		}
	});
    LoadTinyMCE();
});
</script>
<?php }?>
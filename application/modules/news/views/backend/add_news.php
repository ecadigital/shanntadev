<?php if(isset($redirect)){ echo $redirect; }else{ ?>
<script type="text/javascript" src="<?php echo DIR_PUBLIC?>js/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="<?php echo DIR_PUBLIC?>js/tiny_mce/load.js"></script>

<h3>เพิ่มข่าวและอีเว้นท์</h3>
<div>
	<a href="<?php echo DIR_ROOT?>admin/admin/index">หน้าแรก</a>&nbsp;&nbsp;>&nbsp;&nbsp;
    <a href="<?php echo DIR_ROOT?>news/backend/index">ข่าวและอีเว้นท์</a>&nbsp;&nbsp;>&nbsp;&nbsp;
	เพิ่มข่าวและอีเว้นท์
</div>

<div id="showWarning" style="height:40px;"></div>

<div class="fluid">
	<iframe frameborder="0" width="0" height="0" id="myIframe" name="myIframe"></iframe>
	<form class="formElement" method="post" id="news_form" name="news_formAdd" target="myIframe" action="<?php echo DIR_ROOT?>news/backend/add_news">
        <div class="widget">
                        
            <div class="formRow">
                <div class="grid2">
                    <label class="lbl fl" for="news_name"><?php echo lang('news_name');?></label>
                    <span class="required"></span>
                </div>
                <div class="grid5">
                    <input type="text" id="news_name" name="news_name">
                </div>
            </div>
           	<div class="clear"></div>
            
            <div class="formRow">
                <div class="grid2">
                    <label class="lbl fl" for="news_detail"><?php echo lang('news_detail');?></label>
                </div>
                <div class="grid9">
                    <textarea id="news_detail" name="news_detail" class="mceEditor"></textarea>
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
	$("#news_form").validate({
		rules: {
			'news_name' : {
				required: true,
			},
		},
	   	submitHandler: function(form) {
			document.news_formAdd.submit();
	 	}
	});
    $("#file_upload").uploadfile({ module:"news" });
    LoadTinyMCE();
	
});

</script>
<?php }?>
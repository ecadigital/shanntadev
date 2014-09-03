<?php if(isset($redirect)){ echo $redirect; }else{ ?>
<script type="text/javascript" src="<?php echo DIR_PUBLIC?>js/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="<?php echo DIR_PUBLIC?>js/tiny_mce/load.js"></script>

<h3>แก้ไขข่าวและอีเว้นท์</h3>
<div>
	<a href="<?php echo DIR_ROOT?>admin/admin/index">หน้าแรก</a>&nbsp;&nbsp;>&nbsp;&nbsp;
    <a href="<?php echo DIR_ROOT?>news/backend/index">ข่าวและอีเว้นท์</a>&nbsp;&nbsp;>&nbsp;&nbsp;
	แก้ไขข่าวและอีเว้นท์
</div>

<div id="showWarning" style="height:40px;"></div>

<div class="fluid">
	<iframe frameborder="0" width="0" height="0" id="myIframe" name="myIframe"></iframe>
	<form class="formElement" method="post" id="news_form" name="news_formEdit" target="myIframe" action="<?php echo DIR_ROOT?>news/backend/edit_news">
        <div class="widget">   
                     
            <div class="formRow">
                <div class="grid2">
                    <label class="lbl fl" for="news_name"><?php echo lang('news_name');?></label>
                    <span class="required"></span>
                </div>
                <div class="grid5">
                    <input type="text" id="news_name" name="news_name" value="<?php echo $listEditNews['news_name'];?>">
                </div>
            </div>
           	<div class="clear"></div>
            
            <div class="formRow">
                <div class="grid2">
                    <label class="lbl fl" for="news_detail"><?php echo lang('news_detail');?></label>
                </div>
                <div class="grid9">
                    <textarea id="news_detail" name="news_detail" class="mceEditor"><?php echo $listEditNews['news_detail'];?></textarea>
                </div>
            </div>
           	<div class="clear" style="height:10px;"></div>
            
            <div class="formRow">
                <div class="grid11">            
                    <fieldset style="margin-top:20px;">
                        <legend><?php echo lang('web_image');?></legend>
                        <input type="file" id="file_upload" name="file_upload">
                        <?php if(!empty($listEditNews['news_images'])){?>
                        <ul id="UploadQueue" class="hidden">
                            <?php foreach($listEditNews['news_images'] as $index=>$news_images){?>
                            <li class="queue" id="EditUpload_0_<?php echo $index?>" data-itemid="<?php echo $news_images['news_images_id'];?>"><?php echo $news_images['news_images_path'];?></li>
                            <?php }?>
                        </ul>
                        <?php }?>
                        <div class="txt_notify">* <?php echo lang('web_notify_multi_upload');?></label></div>
                    </fieldset>
                </div>
            </div>
           	<div class="clear" style="height:10px;"></div>
            
            <div class="formRow">   
                <input type="hidden" id="news_id" name="news_id" value="<?php echo $listEditNews['news_id'];?>"></input>
                <input type="hidden" id="captcha" name="captcha" value=""></input>
                <input type="submit" class="button" value="<?php echo lang('web_save');?>"></input>
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
			document.news_formEdit.submit();
	 	}
	});
    $("#file_upload").uploadfile({ module:"news" });
    LoadTinyMCE();
});
</script>
<?php }?>
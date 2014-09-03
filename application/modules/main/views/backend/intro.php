<?php if(isset($redirect)){ echo $redirect; }else{ ?>
<script type="text/javascript" src="<?php echo DIR_PUBLIC?>js/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="<?php echo DIR_PUBLIC?>js/tiny_mce/load.js"></script>

<h3>หน้า Intro</h3>
<div>
	<a href="<?php echo DIR_ROOT?>admin/admin/index">หน้าแรก</a>&nbsp;&nbsp;>&nbsp;&nbsp;
    หน้า Intro
</div>

<div id="showWarning" style="height:40px;"></div>

<div class="fluid">
	<iframe frameborder="0" width="0" height="0" id="myIframe" name="myIframe"></iframe>
	<form class="formElement" method="post" id="intro_form" name="intro_formEdit" target="myIframe" action="<?php echo DIR_ROOT?>main/backend/intro" enctype="multipart/form-data">
        <div class="widget">  

            <div class="formRow">
                <div class="grid2">
                    <label class="lbl fl" for="main_intro">รายละเอียด</label>
                </div>
                <div class="grid9">
                    <textarea id="main_intro" name="main_intro" style="height:100px;" class="mceEditor"><?php echo $listEditMain['main_intro'];?></textarea>
                </div>
            </div>
            <div class="clear" style="height:10px;"></div>

            <div class="formRow">
                <div class="grid2">&nbsp;</div>
                <div class="grid9">
                    <input type="checkbox" id="main_intro_show" name="main_intro_show" value="1" <?php if($listEditMain['main_intro_show']==1) echo 'checked="checked"';?> /> <label for="main_intro_show">แสดงหน้า Intro</label>
                </div>
            </div>
            <div class="clear" style="height:10px;"></div>
            
            <div class="formRow">
                <input type="hidden" id="captcha" name="captcha" value=""></input>
                <input type="submit" class="button" value="<?php echo lang('web_save');?>"></input>
            </div>
           	<div class="clear"></div>
        </div>
    </form>
</div>
<script>
$(document).ready(function(){
	$("#collection_form").validate({
		/*rules: {
			'collection_name' : {
				required: true,
			},
		},*/
	   	submitHandler: function(form) {
			document.collection_formEdit.submit();
	 	}
	});
    LoadTinyMCE(); //ใช้แล้ว <secton> ไม่ขึ้น
});
</script>
<?php }?>
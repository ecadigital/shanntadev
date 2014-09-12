<?php if(isset($redirect)){ echo $redirect; }else{ ?>
<script type="text/javascript" src="<?php echo DIR_PUBLIC?>js/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="<?php echo DIR_PUBLIC?>js/tiny_mce/load.js"></script>

<h3>แก้ไข FAQ</h3>
<div>
	<a href="<?php echo DIR_ROOT?>admin/admin/index">หน้าแรก</a>&nbsp;&nbsp;>&nbsp;&nbsp;
    <a href="<?php echo DIR_ROOT?>faq/backend/index"> FAQ</a>&nbsp;&nbsp;>&nbsp;&nbsp;
	แก้ไข FAQ
</div>

<div id="showWarning" style="height:40px;"></div>

<div class="fluid">
	<iframe frameborder="0" width="0" height="0" id="myIframe" name="myIframe"></iframe>
	<form class="formElement" method="post" id="faq_form" name="faq_formEdit" target="myIframe" action="<?php echo DIR_ROOT?>faq/backend/edit_faq">
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
								<label class="lbl fl" for="faq_question[<?php echo $lang_id?>]">คำถาม</label>
								<span class="required"></span>
							</div>
							<div class="grid5">
								<input type="text" id="faq_question[<?php echo $lang_id?>]" name="faq_question[<?php echo $lang_id?>]" value="<?php echo $listEditFaq['faq_question'][$lang_id];?>">
							</div>
						</div>
						<div class="clear"></div>
						
						<div class="formRow">
							<div class="grid2">
								<label class="lbl fl" for="faq_answer[<?php echo $lang_id?>]">คำตอบ</label>
							</div>
							<div class="grid9">
								<textarea id="faq_answer[<?php echo $lang_id?>]" name="faq_answer[<?php echo $lang_id?>]" class="mceEditor"><?php echo $listEditFaq['faq_answer'][$lang_id];?></textarea>
							</div>
						</div>
						<div class="clear" style="height:10px;"></div>
                    </fieldset>
                </div>
            </div>
            <div class="clear" style="height:10px;"></div>
            <?php }}?>
                        
            <div class="formRow">   
                <input type="hidden" id="faq_id" name="faq_id" value="<?php echo $listEditFaq['faq_id'];?>"></input>
                <input type="hidden" id="captcha" name="captcha" value=""></input>
                <input type="submit" class="button" value="<?php echo lang('web_save');?>"></input>
            </div>
    </form>
</div>

<script>
$(document).ready(function(){
	$("#faq_form").validate({
		rules: {
			'faq_question[1]' : {
				required: true,
			},
			'faq_answer[1]' : {
				required: true,
			},
		},
	   	submitHandler: function(form) {
			document.faq_formEdit.submit();
	 	}
	});
    LoadTinyMCE();
});
</script>
<?php }?>
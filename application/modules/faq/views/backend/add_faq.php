<?php if(isset($redirect)){ echo $redirect; }else{ ?>
<script type="text/javascript" src="<?php echo DIR_PUBLIC?>js/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="<?php echo DIR_PUBLIC?>js/tiny_mce/load.js"></script>

<h3>เพิ่ม FAQ</h3>
<div>
	<a href="<?php echo DIR_ROOT?>admin/admin/index">หน้าแรก</a>&nbsp;&nbsp;>&nbsp;&nbsp;
    <a href="<?php echo DIR_ROOT?>faq/backend/index"> FAQ</a>&nbsp;&nbsp;>&nbsp;&nbsp;
	เพิ่ม FAQ
</div>

<div id="showWarning" style="height:40px;"></div>

<div class="fluid">
	<iframe frameborder="0" width="0" height="0" id="myIframe" name="myIframe"></iframe>
	<form class="formElement" method="post" id="faq_form" name="faq_formAdd" target="myIframe" action="<?php echo DIR_ROOT?>faq/backend/add_faq">
        <div class="widget">
                        
            <div class="formRow">
                <div class="grid2">
                    <label class="lbl fl" for="faq_question">คำถาม</label>
                    <span class="required"></span>
                </div>
                <div class="grid5">
                    <input type="text" id="faq_question" name="faq_question">
                </div>
            </div>
           	<div class="clear"></div>
            
            <div class="formRow">
                <div class="grid2">
                    <label class="lbl fl" for="faq_answer">คำตอบ</label>
                </div>
                <div class="grid9">
                    <textarea id="faq_answer" name="faq_answer" class="mceEditor"></textarea>
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
	$("#faq_form").validate({
		rules: {
			'faq_name' : {
				required: true,
			},
		},
	   	submitHandler: function(form) {
			document.faq_formAdd.submit();
	 	}
	});
    LoadTinyMCE();
	
});

</script>
<?php }?>
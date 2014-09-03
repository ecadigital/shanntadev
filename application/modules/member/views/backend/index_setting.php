<?php if(isset($redirect)){ echo $redirect; }else{ ?>

<h3><?php echo lang('member_setting_ii');?></h3>
<div>
	<a href="<?php echo DIR_ROOT?>admin/admin/index">หน้าแรก</a>&nbsp;&nbsp;>&nbsp;&nbsp;
	<a href="<?php echo DIR_ROOT?>member/backend/index"><?php echo lang('member_ii');?></a>&nbsp;&nbsp;>&nbsp;&nbsp;
    <?php echo lang('member_setting_ii');?>
</div>
<div id="showWarning" style="height:40px;"></div>
<div class="fluid">
    <div class="widget">
        
        <iframe frameborder="0" width="0" height="0" id="myIframe" name="myIframe"></iframe>
        <form class="formElement" method="post" id="member_form" name="member_formAdd" target="myIframe" action="<?php echo DIR_ROOT?>member/backend/index_setting">
            <div class="formRow">
                <div class="grid2">
                    <label class="lbl fl" for="main_email">อีเมล์สำหรับรับอีเมล์จากสมาชิก</label>
                    <span class="required"></span>
                </div>
                <div class="grid2">
                    <input type="text" id="main_email" name="main_email" value="<?php echo $getMain['main_email'];?>">
                </div>
            </div>
            <div class="clear"></div>
            <div class="formRow">
                <input type="hidden" id="captcha" name="captcha" value=""></input>
                <input type="submit" class="button" value="<?php echo lang('web_save');?>"></input>
            </div>
        </form>
        <!--<div class="formRow">
            <div class="grid6" id="boxContent_occupation" style="border-right:1px solid #ccc;"></div>
			<div class="grid6" id="boxContent_income"></div>
		</div>-->
    </div>
</div>
<script>
/*$(document).ready(function (){
	//loadAjax('<?php echo DIR_ROOT.$targetpage_occupation?>','#boxContent_occupation','');
	//loadAjax('<?php echo DIR_ROOT.$targetpage_income?>','#boxContent_income','');
});*/
</script>
<?php }?>
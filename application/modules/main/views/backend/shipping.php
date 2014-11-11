<?php if(isset($redirect)){ echo $redirect; }else{ ?>
<script type="text/javascript" src="<?php echo DIR_PUBLIC?>js/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="<?php echo DIR_PUBLIC?>js/tiny_mce/load.js"></script>

<h3>หน้าข้อมูลการจัดส่ง</h3>
<div>
	<a href="<?php echo DIR_ROOT?>admin/admin/index">หน้าแรก</a>&nbsp;&nbsp;>&nbsp;&nbsp;
	จัดการหน้าอื่นๆ&nbsp;&nbsp;>&nbsp;&nbsp;
	หน้าข้อมูลการจัดส่ง
</div>

<div id="showWarning" style="height:40px;"></div>

<div class="fluid">
	<iframe frameborder="0" width="0" height="0" id="myIframe" name="myIframe"></iframe>
	<form class="formElement" method="post" id="main_form" name="main_formEdit" target="myIframe" action="<?php echo DIR_ROOT?>main/backend/shipping">
        <div class="widget">
						
	        <?php if(!empty($listAllLang)){foreach($listAllLang as $lang){
				$lang_icon = ($lang['language_icon'] != '')?'<img src="'.DIR_ROOT.$lang['language_icon'].'" title="'.$lang['language_desc'].'" style="margin-left:3px;" />':'';
				$lang_id = $lang['language_id'];
			?>			
			<div class="formRow">
				<div class="grid2">
					<label class="lbl fl" for="main_shipping[<?php echo $lang_id?>]">ข้อความ <?php echo $lang_icon;?></label>
				</div>
				<div class="grid9">
                    <textarea id="main_shipping[<?php echo $lang_id?>]" name="main_shipping[<?php echo $lang_id?>]" class="mceEditor"><?php echo $listEditMain['main_shipping'][$lang_id];?></textarea>
				</div>
			</div>
			<div class="clear" style="height:10px;"></div>
			<?php }}?>
			
            <div class="formRow">
                <input type="hidden" id="captcha" name="captcha" value=""></input>
                <input type="hidden" id="main_id" name="main_id" value="1"></input>
                <input type="submit" class="button" value="<?php echo lang('web_save');?>"></input>
			</div>
		</div>
	</form>
</div>
<script>
$(document).ready(function(){
    LoadTinyMCE();
});
</script>
<?php }?>
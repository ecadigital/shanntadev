<?php if(isset($redirect)){ echo $redirect; }else{ ?>
<h3>แก้ไขข้อมูลการติดต่อ</h3>
<div>
	<a href="<?php echo DIR_ROOT?>admin/admin/index">หน้าแรก</a>&nbsp;&nbsp;>&nbsp;&nbsp;
	ติดต่อเรา&nbsp;&nbsp;>&nbsp;&nbsp;
	แก้ไขข้อมูลการติดต่อ
</div>

<div id="showWarning" style="height:40px;"></div>

<div class="fluid">
	<iframe frameborder="0" width="0" height="0" id="myIframe" name="myIframe"></iframe>
	<form class="formElement" method="post" id="main_form" name="main_formEdit" target="myIframe" action="<?php echo DIR_ROOT?>main/backend/contact">
        <div class="widget">
			
			<!--<div class="formRow">
				<div class="grid2">
					<label class="lbl fl" for="main_tel">เบอร์โทรศัพท์</label>
				</div>
				<div class="grid3">
					<input type="text" id="main_tel" name="main_tel" value="<?php echo $listEditMain['main_tel'];?>" />
				</div>
			</div>  -->   
			
	        <?php if(!empty($listAllLang)){foreach($listAllLang as $lang){
				$lang_icon = ($lang['language_icon'] != '')?'<img src="'.DIR_ROOT.$lang['language_icon'].'" title="'.$lang['language_desc'].'" style="margin-left:3px;" />':'';
				$lang_id = $lang['language_id'];
				?>
				<div class="formRow">
					<div class="grid2">
						<label class="lbl fl" for="main_contact[<?php echo $lang_id;?>]">ข้อมูลติดต่อ หน้า Contact <?php echo $lang_icon;?></label>
					</div>
					<div class="grid6">
						<textarea id="main_contact[<?php echo $lang_id;?>]" name="main_contact[<?php echo $lang_id;?>]" style="height:50px;"><?php echo $listEditMainLang['main_contact'][$lang_id];?></textarea>
					</div>
				</div>
				<div class="clear" style="height:10px;"></div>
				
				<div class="formRow">
					<div class="grid2">
						<label class="lbl fl" for="main_footer[<?php echo $lang_id;?>]">ข้อมูลติดต่อ ส่วน Footer <?php echo $lang_icon;?></label>
					</div>
					<div class="grid6">
						<textarea id="main_footer[<?php echo $lang_id;?>]" name="main_footer[<?php echo $lang_id;?>]" style="height:50px;"><?php echo $listEditMainLang['main_footer'][$lang_id];?></textarea>
					</div>
				</div>
				<div class="clear" style="height:10px;"></div>
			<?php }}?>
			
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
			<!--<div class="formRow">
				<div class="grid2">
					<label class="lbl fl" for="main_twitter">ทวิตเตอร์</label>
				</div>
				<div class="grid9">
					http://www.twitter.com/<input type="text" id="main_twitter" name="main_twitter" value="<?php echo $listEditMain['main_twitter'];?>" style="width:162px;" />
				</div>
			</div>-->			   
			<div class="formRow">
				<div class="grid2">
					<label class="lbl fl" for="main_instagram">อินสตาแกรม</label>
				</div>
				<div class="grid9">
					@<input type="text" id="main_instagram" name="main_instagram" value="<?php echo $listEditMain['main_instagram'];?>" style="width:162px;" />
				</div>
			</div>			
			<div class="clear" style="height:10px;"></div>
			
            <div class="formRow">
                <input type="hidden" id="captcha" name="captcha" value=""></input>
                <input type="hidden" id="main_id" name="main_id" value="1"></input>
                <input type="submit" class="button" value="<?php echo lang('web_save');?>"></input>
			</div>
		</div>
	</form>
</div>
<?php }?>
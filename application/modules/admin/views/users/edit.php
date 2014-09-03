<?php if(isset($redirect)) {echo $redirect;}else{?>
<h3>แก้ไข Admin</h3>

<div id="showWarning" style="height:40px;"></div>

<div class="fluid">
	<iframe frameborder="0" width="0" height="0" id="myIframe" name="myIframe"></iframe>
	<form class="formElement" method="post" id="users_form" name="users_formEdit" target="myIframe" enctype="multipart/form-data" action="<?php echo DIR_ROOT?>admin/users/edit<?php echo $param;?>">
		<div class="widget">
			<div class="formRow" style="height:50px;">
				<div class="grid3">
					<label class="lbl" for="admin_name">ระดับ Admin</label>
					<span class="required"></span>
				</div>
				<div class="grid3">
                	<div>
						<input type="radio" id="admin_group_2" name="admin_group_id"  value="2" <?php echo ($listEdit['admin_group_id'] == 2)?'checked="checked"':'';?>/>&nbsp;&nbsp;<label for="admin_group_2">Admin ระดับสูง</label>
                    </div>
					<input type="radio" id="admin_group_3" name="admin_group_id"  value="3" <?php echo ($listEdit['admin_group_id'] == 3)?'checked="checked"':'';?>/>&nbsp;&nbsp;<label for="admin_group_3">Admin ระดับกลาง</label>
				</div>
				<div class="clear"></div>
			</div>
			<div class="formRow" style="height:50px;">
				<div class="grid3">
					<label class="lbl" for="admin_name">ชื่อ - นามสกุล</label>
					<span class="required"></span>
				</div>
				<div class="grid3">
					<input type="text" id="admin_name" name="admin_name" value="<?php echo $listEdit['admin_name'];?>" >
				</div>
				<div class="clear"></div>
			</div>
			<div class="formRow" style="height:50px;">
				<div class="grid3">
					<label class="lbl" for="admin_email">อีเมล์</label>
					<span class="required"></span>
				</div>
				<div class="grid3">
					<input type="text" id="admin_email" name="admin_email" value="<?php echo $listEdit['admin_email'];?>" >
				</div>
				<div class="clear"></div>
			</div>
			<div class="formRow" style="height:50px;">
				<div class="grid3">
					<label class="lbl" for="admin_user">ชื่อผู้ใช้</label>
					<span class="required"></span>
				</div>
				<div class="grid3">
					<input type="text" id="admin_user" name="admin_user" value="<?php echo $listEdit['admin_user'];?>" >
				</div>
				<div class="clear"></div>
			</div>
            <hr />
            <h4>เปลี่ยนรหัสผ่าน</h4>
            <div style="margin:-10px 0 10px -10px;"><label class="note" style="display: inline;">กรอกเมื่อต้องการเปลี่ยนรหัสผ่าน</label></div>
			<div class="formRow" style="height:50px;">
				<div class="grid3">
					<label class="lbl" for="admin_new_pass">รหัสผ่านใหม่</label>
				</div>
				<div class="grid3">
					<input type="password" id="admin_new_pass" name="admin_new_pass" value="">
				</div>
				<div class="clear"></div>
			</div>
			<div class="formRow" style="height:50px;">
				<div class="grid3">
					<label class="lbl" for="admin_con_pass">ยืนยันรหัสผ่านใหม่</label>
				</div>
				<div class="grid3">
					<input type="password" id="admin_con_pass" name="admin_con_pass" value="">
                    <div style="margin-left:-10px; display:none;" id="error_admin_con_pass"><label class="note" style="display:inline;">กรอกรหัสผ่านใหม่ไม่ถูกต้อง</label></div>
				</div>
				<div class="clear"></div>
			</div>
            
			<?php /*?>
			<div class="formRow" style="height:100px;">
				<fieldset>
					<legend><?php echo lang('web_status');?></legend>
					
					<div class="grid9">
						<input type="radio" id="admin_block_1" name="admin_block" value="1" <?php echo ($listEdit['admin_block']=='1')?'checked="checked"':'';?>/>&nbsp;&nbsp;<label for='admin_block_1'>Normal</label>
					</div>
					<div class="grid9">
						<input type="radio" id="admin_block_0" name="admin_block" value="0" <?php echo ($listEdit['admin_block']=='0')?'checked="checked"':'';?>/>&nbsp;&nbsp;<label for='admin_block_0'>Block</label>
					</div>
					
				</fieldset>
			</div>
			<?php if($listEdit['admin_group_id'] != 1){?>
			<div class="formRow" style="height:80px;">
				<fieldset>
					<legend>กลุ่มสมาชิก</legend>
					<?php foreach($listGroupUser as $key=>$list){?>
					<div class="grid9">
						<input type="radio" id="admin_group_<?php echo $list['admin_group_id'];?>" name="admin_group_id"  value="<?php echo $list['admin_group_id'];?>" <?php echo ($listEdit['admin_group_id'] == $list['admin_group_id'])?'checked="checked"':'';?>/>&nbsp;&nbsp;<label for='admin_group_<?php echo $list['admin_group_id'];?>'><?php echo $list['admin_group_desc'];?></label>
					</div>
					<?php }?>
				</fieldset>
			</div>
			<?php }else{?>
			<input type="hidden" id="admin_group_id" name="admin_group_id" value="<?php echo $listEdit['admin_group_id']?>"></input>
			<?php }?><?php */?>
			<div class="formRow">
				<input type="hidden" id="admin_id" name="admin_id" value="<?php echo $listEdit['admin_id']?>"></input>
				<input type="submit" class="button" value="Submit"></input>
				<div class="clear"></div>
			</div>
		</div>
	</form>
</div>
<style>
.note, #error_admin_con_pass label{
    color: #E46C6E;
    font-size: 85%;
    font-style: italic;
    margin: 5px 0 5px 10px;
}
</style>
<script>
$("#users_form").validate({
	rules: {
		admin_user: {
			required: true,
			remote: DIR_ROOT+"admin/users/chk_username/id/"+<?php echo $listEdit['admin_id']?>
		},
		admin_email: {
			required: true,
			email: true,
			remote: DIR_ROOT+"admin/users/chk_email/id/"+<?php echo $listEdit['admin_id']?>
		}/*,
		admin_new_pass: {
			minlength: 6
		},
		admin_con_pass: {
			minlength: 6,
			equalTo: "#admin_new_pass"
		}*/
   },
   submitHandler: function(form) {
		if($('#admin_new_pass').val()==''||$('#admin_con_pass').val()==''){
			document.users_formEdit.submit();
		}else{
			chk=1;
			if($('#admin_new_pass').val()!=$('#admin_con_pass').val()){
				$('#error_admin_con_pass').show();
				chk=0;	
			}
			if(chk==1){
				document.users_formEdit.submit();
			}
		}
 	}
});
</script>
<?php }if(isset($error)) {echo $error;}?>
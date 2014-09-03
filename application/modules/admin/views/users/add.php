<?php if(isset($redirect)) {echo $redirect;}else{
	
if($p==2){ 	$name = "Admin ระดับสูง";		$admin_group_id = 2;	$admin_group_can = 'จัดการข้อมูลได้ทุกอย่าง';  }
else		{	$name = "Admin ระดับกลาง";	$admin_group_id = 3;	$admin_group_can = 'จัดการข้อมูลสินค้า, รายการสั่งซื้อ, ข่าว/โปรโมชั่น, ติดต่อเรา และจัดการหน้าอื่นๆ';  }
?>

<h3>เพิ่ม <?php echo $name;?></h3>
<div style="color:#E46C6E;"><i><?php echo $admin_group_can;?></i></div>

    
    
<div id="showWarning" style="height:40px;"></div>

<div class="fluid">
	<iframe frameborder="0" width="0" height="0" id="myIframe" name="myIframe"></iframe>
	<form class="formElement" method="post" id="users_form" name="users_formAdd" target="myIframe" enctype="multipart/form-data" action="<?php echo DIR_ROOT?>admin/users/add<?php echo $param;?>">
		<div class="widget">
			<div class="formRow" style="height:50px;">
				<div class="grid3">
					<label class="lbl" for="admin_name">ชื่อ - นามสกุล</label>
					<span class="required"></span>
				</div>
				<div class="grid3">
					<input type="text" id="admin_name" name="admin_name" >
				</div>
				<div class="clear"></div>
			</div>
			<div class="formRow" style="height:50px;">
				<div class="grid3">
					<label class="lbl" for="admin_email">อีเมล์</label>
					<span class="required"></span>
				</div>
				<div class="grid3">
					<input type="text" id="admin_email" name="admin_email" >
				</div>
				<div class="clear"></div>
			</div>
			<div class="formRow" style="height:50px;">
				<div class="grid3">
					<label class="lbl" for="admin_user">ชื่อผู้ใช้</label>
					<span class="required"></span>
				</div>
				<div class="grid3">
					<input type="text" id="admin_user" name="admin_user" >
				</div>
				<div class="clear"></div>
			</div>
			<div class="formRow" style="height:50px;">
				<div class="grid3">
					<label class="lbl" for="admin_pass">รหัสผ่าน</label>
					<span class="required"></span>
				</div>
				<div class="grid3">
					<input type="password" id="admin_pass" name="admin_pass" >
				</div>
				<div class="clear"></div>
			</div>
			<div class="formRow" style="height:50px;">
				<div class="grid3">
					<label class="lbl" for="admin_pass_cf">ยืนยันรหัสผ่าน</label>
					<span class="required"></span>
				</div>
				<div class="grid3">
					<input type="password" id="admin_pass_cf" name="admin_pass_cf" >
				</div>
				<div class="clear"></div>
			</div>
			<input type="hidden" name="admin_group_id" id="admin_group_id" value="<?php echo $admin_group_id;?>" />
            
			<!--
			<div class="formRow">
				<fieldset>
					<legend>กลุ่มสมาชิก</legend>
					<?php foreach($listGroupUser as $key=>$list){?>
					<div class="grid9">
						<input type="radio" id="admin_group_<?php echo $list['admin_group_id'];?>" name="admin_group_id" value="<?php echo $list['admin_group_id'];?>" <?php echo ($key == 0)?'checked="checked"':'';?>/>&nbsp;&nbsp;<label for='admin_group_<?php echo $list['admin_group_id'];?>'><?php echo $list['admin_group_desc'];?></label>
					</div>
					<?php }?>
				</fieldset>
			</div>
			
			<div class="formRow" style="height:100px;">
				<fieldset>
					<legend><?php echo lang('web_status');?></legend>
					
					<div class="grid9">
						<input type="radio" id="admin_block_1" name="admin_block" value="1" checked="checked"/>&nbsp;&nbsp;<label for='admin_block_1'>Normal</label>
					</div>
					<div class="grid9">
						<input type="radio" id="admin_block_0" name="admin_block" value="0" />&nbsp;&nbsp;<label for='admin_block_0'>Block</label>
					</div>
					
				</fieldset>
			</div>
			<div class="formRow">
				
				<div class="grid3">
					<label class="lbl" for="userfile">รูปสมาชิก</label>
				</div>
				<div class="grid9">
					<input type="file" id="userfile" name="userfile" size="40">
					<span class="f_help">ขนาดรูปไม่เกิน 600x600</span>
				</div>
				<div class="clear"></div>
			</div>-->
	
			<div class="formRow">
				<input type="submit" class="button" value="Submit"></input>
				<div class="clear"></div>
			</div>
		</div>
	</form>
</div>
<script>
$("#users_form").validate({
	rules: {
		admin_user: {
			required: true,
			remote: DIR_ROOT+"admin/users/chk_username"
		},
		admin_email: {
			required: true,
			email: true,
			remote: DIR_ROOT+"admin/users/chk_email"
		},
		admin_pass: {
			required: true,
			minlength: 6
		},
		admin_pass_cf: {
			required: true,
			minlength: 6,
			equalTo: "#admin_pass"
		}
   },
   submitHandler: function(form) {
		document.users_formAdd.submit();
 	}
});
</script>
<?php }if(isset($error)) {echo $error;}?>
<?php if(isset($redirect)){ echo $redirect; }else{ ?>

<h3><?php echo lang('member_edit');?></h3>
<div>
	<a href="<?php echo DIR_ROOT?>admin/admin/index">หน้าแรก</a>&nbsp;&nbsp;>&nbsp;&nbsp;
    <a href="<?php echo DIR_ROOT?>member/backend/index"><?php echo lang('member_ii');?></a>&nbsp;&nbsp;>&nbsp;&nbsp;
	<?php echo lang('member_edit');?>
</div>

<div id="showWarning" style="height:40px;"></div>

<div class="fluid">
	<iframe frameborder="0" width="0" height="0" id="myIframe" name="myIframe"></iframe>
	<form class="formElement" method="post" id="member_form" name="member_formEdit" target="myIframe" action="<?php echo DIR_ROOT?>member/backend/edit_member">
        <div class="widget">
            <!--<div class="formRow">
                <div class="grid2">
                    <label class="lbl fl" for="member_code">Code</label>
                    <span class="required"></span>
                </div>
                <div class="grid2">
                    <input type="text" id="member_code" name="member_code" value="<?php echo $listEditMember['member_code'];?>">
                </div>
            </div>
           	<div class="clear"></div>-->
            
            <div class="formRow">
                <div class="grid2">
                    <label class="lbl fl" for="member_type">ประเภทสมาชิก</label>
                    <span class="required"></span>
                </div>
                <div class="grid2">
                    <select id="member_type" name="member_type">
                    	<option value="1" <?php if($listEditMember['member_type']==1) echo 'selected="seledted"'; ?>>เอเยนต์</option>
                    	<option value="2" <?php if($listEditMember['member_type']==2) echo 'selected="seledted"'; ?>>สมาชิกขาจร</option>
                    	<option value="0" <?php if($listEditMember['member_type']==0) echo 'selected="seledted"'; ?>>ลูกค้าของเอเยนต์</option>
                    </select>
                </div>
                
                <div class="grid2" id="boxParent">
                	<?php 
					if($listEditMember['member_type']==0&&$listEditMember['parent_id']!=0){
						$listParent = $this->model->listParent();
						echo '
						<select id="parent_id" name="parent_id">';
							if(!empty($listParent)){
								foreach($listParent as $list){
									echo '<option value="'.$list['member_id'].'"'; if($listEditMember['parent_id']==$list['member_id']) echo 'selected="seledted"'; echo '>'.$list['member_first_name'].' '.$list['member_last_name'].'</option>';
								}
							}
						echo '</select>';
					}
					?>
                </div>
                
            </div>
           	<div class="clear"></div>           
            
            <div class="formRow">
                <div class="grid2">
                    <label class="lbl fl" for="member_email">ชื่อผู้ใช้</label>
                </div>
                <div class="grid3" style="margin-top:7px;">
                    <strong><?php echo $listEditMember['member_email'];?></strong>
                </div>
            </div>
           	<div class="clear"></div>
            
            <div class="formRow">
                <div class="grid2">
                    <label class="lbl fl" for="member_password">รหัสผ่าน</label>
                </div>
                <div class="grid3" style="margin-top:7px;">
                    <strong><?php echo base64_decode($listEditMember['member_pass']);?></strong>
                </div>
            </div>
           	<div class="clear"></div>
            
            <div class="formRow">
                <div class="grid2">
                    <label class="lbl fl" for="member_newpass">รหัสผ่านใหม่</label>
                </div>
                <div class="grid2">
                    <input type="text" id="member_newpass" name="member_newpass" >
                    <label for="member_newpass" class="error" style="display: block;">กรอกเมื่อต้องเปลี่ยนรหัสผ่าน</label>
                </div>
            </div>
           	<div class="clear"></div>
            
            <div class="formRow">
                <div class="grid2">
                    <label class="lbl fl" for="member_first_name"><?php echo lang('member_first_name').' '.lang('member_last_name');?></label>
                    <span class="required"></span>
                </div>
                <div class="grid2">
                    <input type="text" id="member_first_name" name="member_first_name" value="<?php echo $listEditMember['member_first_name'];?>">
                </div>
                <div class="grid2">
                    <input type="text" id="member_last_name" name="member_last_name" value="<?php echo $listEditMember['member_last_name'];?>">
                </div>
            </div>
           	<div class="clear"></div>
            
            <div class="formRow">
                <div class="grid2">
                    <label class="lbl fl" for="member_birthday"><?php echo lang('member_birthday');?></label>
                </div>
                <div class="grid5">
                    <?php echo $this->bflibs->showSelectDay('member_birth_day',$listEditMember['member_birth_day']);?>
                    <?php echo $this->bflibs->showSelectMonth('member_birth_month',$listEditMember['member_birth_month']);?>
                    <?php echo $this->bflibs->showSelectYear('member_birth_year',$listEditMember['member_birth_year']);?>
                </div>
            </div>
           	<div class="clear" style="height:10px;"></div>
            
            <div class="formRow">
                <div class="grid2">
                    <label class="lbl fl" for="member_iden"><?php echo lang('member_iden');?></label>
                </div>
                <div class="grid3">
                    <input type="text" id="member_iden" name="member_iden" value="<?php echo $listEditMember['member_iden'];?>">
                </div>
            </div>
           	<div class="clear"></div>
            
            <div class="formRow">
                <div class="grid2">
                    <label class="lbl fl" for="member_tel"><?php echo lang('member_tel');?></label>
                    <span class="required"></span>
                </div>
                <div class="grid2">
                    <input type="text" id="member_tel" name="member_tel" value="<?php echo $listEditMember['member_tel'];?>">
                </div>
            </div>
           	<div class="clear"></div>
            
            <div class="formRow">
                <div class="grid2">
                    <label class="lbl fl" for="member_address"><?php echo lang('member_address');?></label>
                </div>
                <div class="grid5">
                    <textarea id="member_address" name="member_address" style="height:60px;"><?php echo $listEditMember['member_address'];?></textarea>
                </div>
            </div>
           	<div class="clear" style="height:5px;"></div>
            
            <div class="formRow" id="boxDiscount" <?php //if($listEditMember['member_type']!=0) echo 'style="display:none;"';?>>
                <div class="grid2">
                    <label class="lbl fl" for="member_discount">ส่วนลด</label>
                </div>
                <div class="grid2">
                    <input type="text" id="member_discount" name="member_discount" value="<?php echo $listEditMember['member_discount'];?>" onkeypress="return chkNumberOnly(event)" style="text-align:right; width:30px;">%
                </div>
            </div>
           	<div class="clear" style="height:5px;"></div> 
            
            <?php /*?><div class="formRow">
                <div class="grid2">
                    <label class="lbl fl" for="member_occupation"><?php echo lang('member_occupation');?></label>
                </div>
                <div class="grid2">
                    <?php 
					$txt_member_occupation = '';
					$chk_member_occupation = '';
					$arr = mysql_query("SELECT 	* FROM member_occupation WHERE member_occupation_publish='1' ORDER BY member_occupation_seq ASC");
					$countData = mysql_num_rows($arr);
					if($countData>0){
						$txt_member_occupation .= '
						<div class="fl">
							<select id="member_occupation" name="member_occupation" style="width:195px;">
								<option value="">'.lang('member_occupation_pls_select').'</option>';
								while($listOccupation = mysql_fetch_array($arr)){
									$sl = '';
									if($listEditMember['member_occupation'] == $listOccupation['member_occupation_name']){
										$chk_member_occupation = $listOccupation['member_occupation_name'];
										$sl = 'selected="selected"';
									}
									$txt_member_occupation .= '<option value="'.$listOccupation['member_occupation_name'].'" '.$sl.'>'.$listOccupation['member_occupation_name'].'</option>';
								}
								$txt_member_occupation .= '
								<option value="-">'.lang('member_occupation_other').'</option>
							</select>
						</div>';
					}
					echo $txt_member_occupation;
					?>
                </div>                
                <div class="grid2" id="box_member_occupation_other" style="display:none;">
					<input type="text" id="member_occupation_other" name="member_occupation_other" placeholder="<?php echo lang('member_occupation_other_pls_type');?>" value="<?php echo $chk_member_occupation;?>">
                </div>
            </div>
           	<div class="clear"></div>
            
            <div class="formRow">
                <div class="grid2">
                    <label class="lbl fl" for="member_income"><?php echo lang('member_income');?></label>
                </div>
                <div class="grid2">
                    <?php 
					$txt_member_income = '';
					$arr = mysql_query("SELECT 	* FROM member_income WHERE member_income_publish='1' ORDER BY member_income_seq ASC");
					$countData = mysql_num_rows($arr);
					if($countData>0){
						$txt_member_income .= '
						<select id="member_income" name="member_income" style="width:195px;">
							<option value="">'.lang('member_income_pls_select').'</option>';
							while($listIncome = mysql_fetch_array($arr)){
								$sl = '';
								if($listEditMember['member_income'] == $listIncome['member_income_name']){
									$sl = 'selected="selected"';
								}
								$txt_member_income .= '<option value="'.$listIncome['member_income_name'].'" '.$sl.'>'.$listIncome['member_income_name'].'</option>';
							}
							$txt_member_income .= '
						</select>';
					}
					echo $txt_member_income;
					?>	
                </div>
            </div>
           	<div class="clear"></div><?php */?>
           	<div class="clear" style="height:10px;"></div>   
            
            <div class="formRow">   
                <input type="hidden" id="member_id" name="member_id" value="<?php echo $listEditMember['member_id'];?>"></input>
                <input type="hidden" id="captcha" name="captcha" value=""></input>
                <input type="submit" class="button" value="<?php echo lang('web_save');?>"></input>
            </div>
    </form>
</div>

<script>
$(document).ready(function(){
	jQuery.validator.addMethod("trueiden", function(value, element) {
		if(value!=''){
			for(i=0, sum=0; i < 12; i++)
			sum += parseFloat(value.charAt(i))*(13-i); 
			if((11-sum%11)%10!=parseFloat(value.charAt(12))) return false; return true;
		}else return true;
	},"<?php echo lang('member_iden_error_pattern');?>");
	
	$('#member_type').change(function(){
		if($(this).val()=='0'){
			$.ajax({ 
				url: "<?php echo DIR_ROOT;?>member/backend/getSelectParent",
				success: function(response){
					$("#boxParent").html(response).fadeIn(300);
					//$('#boxDiscount').show();
				}
			});
			
		}else{
			$('#boxParent').hide();
			//$('#boxDiscount').hide();
		}
	})
	/*$('#member_occupation').change(function(){
		if($(this).val()=='-'){
			$('#box_member_occupation_other').show();
		}else{
			$('#box_member_occupation_other').hide();
		}
	});
	$('#member_status').change(function(){
		if($(this).val()=='มีบุตร'){
			$('#box_member_status_children').show();
		}else{
			$('#box_member_status_children').hide();
		}
	});*/
	$("#member_form").validate({
		rules: {
			'member_first_name' : {
				required: true,
			},
			'member_last_name' : {
				required: true,
			},
			'member_iden' : {
				//required: true,
				//minlength: 13,
				trueiden: true,
				number: true
			},
			'member_email' : {
				required: true,
				//email: true,
				remote:DIR_ROOT+'member/frontend/chkDuplicateEmail/id/<?php echo $listEditMember['member_id'];?>/'
			},
			'member_tel' : {
				required: true,
				number: true
			},
			/*'member_address' : {
				required: true,
			},*/
		},
		messages: {
			'member_iden' :{
				minlength : "Identity number is not complete",
				number : "Please type numberic only",
			},
			'member_email' :{
				//email: "Email is incorrect pattern",
				remote: "Username is duplicate",
			},
			'member_tel' :{
				number : "Please type numberic only",
			},
		},
		submitHandler: function(form) {
			document.member_formEdit.submit();
		}
	});
});
</script>
<?php }?>
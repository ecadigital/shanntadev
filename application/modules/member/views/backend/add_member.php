<?php if(isset($redirect)){ echo $redirect; }else{ ?>

<h3><?php echo lang('member_add');?></h3>
<div>
	<a href="<?php echo DIR_ROOT?>admin/admin/index">หน้าแรก</a>&nbsp;&nbsp;>&nbsp;&nbsp;
    <a href="<?php echo DIR_ROOT?>member/backend/index"><?php echo lang('member_ii');?></a>&nbsp;&nbsp;>&nbsp;&nbsp;
	<?php echo lang('member_add');?>
</div>

<div id="showWarning" style="height:40px;"></div>

<div class="fluid">
	<iframe frameborder="0" width="0" height="0" id="myIframe" name="myIframe"></iframe>
	<form class="formElement" method="post" id="member_form" name="member_formAdd" target="myIframe" action="<?php echo DIR_ROOT?>member/backend/add_member">
        <div class="widget">
            <!--<div class="formRow">
                <div class="grid2">
                    <label class="lbl fl" for="member_code">Code</label>
                </div>
                <div class="grid2">
                    <input type="text" id="member_code" name="member_code">
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
                    	<option value="1">เอเยนต์</option>
                    	<option value="2">สมาชิกขาจร</option>
                    	<option value="0">ลูกค้าของเอเยนต์</option>
                    </select>
                </div>
                
                <div class="grid2" id="boxParent"></div>
                
            </div>
           	<div class="clear"></div>
            
            <div class="formRow">
                <div class="grid2">
                    <label class="lbl fl" for="member_email">ชื่อผู้ใช้</label>
                    <span class="required"></span>
                </div>
                <div class="grid2">
                    <input type="text" id="member_email" name="member_email">
                </div>
            </div>
           	<div class="clear"></div>
            
            <div class="formRow">
                <div class="grid2">
                    <label class="lbl fl" for="member_password">รหัสผ่าน</label>
                    <span class="required"></span>
                </div>
                <div class="grid2">
                    <input type="text" id="member_password" name="member_password" value="">
                </div>
            </div>
           	<div class="clear"></div>
            
            <div class="formRow">
                <div class="grid2">
                    <label class="lbl fl" for="member_first_name"><?php echo lang('member_first_name').' - '.lang('member_last_name');?></label>
                    <span class="required"></span>
                </div>
                <div class="grid2">
                    <input type="text" id="member_first_name" name="member_first_name" placeholder="<?php echo lang('member_first_name');?>">
                </div>
                <div class="grid2">
                    <input type="text" id="member_last_name" name="member_last_name" placeholder="<?php echo lang('member_last_name');?>">
                </div>
            </div>
           	<div class="clear"></div>
            
            <div class="formRow">
                <div class="grid2">
                    <label class="lbl fl" for="member_birthday"><?php echo lang('member_birthday');?></label>
                </div>
                <div class="grid5">
                    <?php echo $this->bflibs->showSelectDay('member_birth_day','');?>
                    <?php echo $this->bflibs->showSelectMonth('member_birth_month','');?>
                    <?php echo $this->bflibs->showSelectYear('member_birth_year','');?>
                </div>
            </div>
           	<div class="clear"></div>     
            
            <div class="formRow">
                <div class="grid2">
                    <label class="lbl fl" for="member_iden"><?php echo lang('member_iden');?></label>
                </div>
                <div class="grid3">
                    <input type="text" id="member_iden" name="member_iden">
                </div>
            </div>
           	<div class="clear"></div>
            
            <div class="formRow">
                <div class="grid2">
                    <label class="lbl fl" for="member_tel"><?php echo lang('member_tel');?></label>
                    <span class="required"></span>
                </div>
                <div class="grid2">
                    <input type="text" id="member_tel" name="member_tel">
                </div>
            </div>
           	<div class="clear"></div> 
            
            <div class="formRow">
                <div class="grid2">
                    <label class="lbl fl" for="member_address"><?php echo lang('member_address');?></label>
                </div>
                <div class="grid5">
                    <textarea id="member_address" name="member_address" style="height:60px;"></textarea>
                </div>
            </div>
           	<div class="clear" style="height:5px;"></div> 
            
            <div class="formRow" id="boxDiscount">
                <div class="grid2">
                    <label class="lbl fl" for="member_discount">ส่วนลด</label>
                </div>
                <div class="grid2">
                    <input type="text" id="member_discount" name="member_discount" onkeypress="return chkNumberOnly(event)" style="text-align:right; width:30px;">%
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
					$arr = mysql_query("SELECT 	* FROM member_occupation WHERE member_occupation_publish='1' ORDER BY member_occupation_seq ASC");
					$countData = mysql_num_rows($arr);
					if($countData>0){
						$txt_member_occupation .= '
						<select id="member_occupation" name="member_occupation" style="width:195px;">
							<option value="">'.lang('member_occupation_pls_select').'</option>';
							while($listOccupation = mysql_fetch_array($arr)){
								$txt_member_occupation .= '<option value="'.$listOccupation['member_occupation_name'].'">'.$listOccupation['member_occupation_name'].'</option>';
							}
							$txt_member_occupation .= '
							<option value="-">'.lang('member_occupation_other').'</option>
						</select>';
					}
					echo $txt_member_occupation;
					?>
                </div>                
                <div class="grid2" id="box_member_occupation_other" style="display:none;">
					<input type="text" id="member_occupation_other" name="member_occupation_other" placeholder="<?php echo lang('member_occupation_other_pls_type');?>" >
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
								$txt_member_income .= '<option value="'.$listIncome['member_income_name'].'">'.$listIncome['member_income_name'].'</option>';
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
                <input type="hidden" id="captcha" name="captcha" value=""></input>
                <input type="submit" class="button" value="<?php echo lang('web_save');?>"></input>
            </div>
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
		if($(this).val()=='0'){ //ลูกค้าของเอเยนต์
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
				remote:DIR_ROOT+'member/frontend/chkDuplicateEmail'
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
			document.member_formAdd.submit();
		}
	});
});

</script>
<?php }?>
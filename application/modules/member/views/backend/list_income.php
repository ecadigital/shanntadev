<?php $pagination = false;
$this->model = $this->load->model('member/Membermodel');
?>

<div id="showWarning_income" style="height:40px; display:none;"></div>
<div class="fluid">
	<iframe frameborder="0" width="0" height="0" id="myIframe_income" name="myIframe_income"></iframe>
	<form class="formElement" method="post" id="income_form" name="income_formAdd" target="myIframe_income" action="<?php echo DIR_ROOT?>member/backend/add_income">
        <div class="widget">
            <div class="formRow">
                <div class="grid2">
                    <label class="lbl fl" for="member_income_name"><?php echo lang('member_income_name');?></label>
                </div>
                <div class="grid4">
                    <input type="text" id="member_income_name" name="member_income_name">
                </div>
                <div class="grid2" style="text-align:right; margin-top:3px;">
                    <input type="hidden" id="captcha" name="captcha" value=""></input>
                    <input type="submit" class="button" value="<?php echo lang('web_save');?>"></input>
                </div>
            </div>
		</div>
    </form>
</div>

<table cellpadding="0" cellspacing="0" border="0" width="100%" class="data"> 
	<thead> 
		<tr> 
			<th align="center" width="50"><?php echo lang('web_no');?></th>
			<th><?php echo lang('member_income_name');?></th>
            <th align="center" width="180"><?php echo lang('web_tool');?></th> 
		</tr> 
	</thead>
	<tbody>
	<?php 
	if(!empty($listIncome)){
		$no=0;
		foreach($listIncome as $list){
			$member_income_id = $list["member_income_id"];
			?>
		<tr>
			<td align="center"><?php echo ++$no;?></td>
			<td>
            	<div id="box_income_name_<?php echo $member_income_id;?>">
					<strong><?php echo $list['member_income_name'];?></strong>
                </div>
            	<div id="boxEdit_income_name_<?php echo $member_income_id;?>" style="display:none;">
                	<iframe frameborder="0" width="0" height="0" id="myIframe_income_<?php echo $member_income_id;?>" name="myIframe_income_<?php echo $member_income_id;?>"></iframe>
					<form method="post" target="myIframe_income_<?php echo $member_income_id;?>" action="<?php echo DIR_ROOT?>member/backend/edit_income" style="margin-top: -18px;">
                		<input type="text" id="income_name_<?php echo $member_income_id;?>" name="member_income_name" value="<?php echo $list['member_income_name'];?>" style="width:70%;" />
                		<input type="hidden" name="member_income_id" value="<?php echo $member_income_id;?>" />
                        <input type="hidden" id="captcha" name="captcha" value=""></input>
                    	<input type="submit" class="button" value="<?php echo lang('web_save');?>"></input>
                    </form>
                </div>
			</td>
			<td align="center">
				<?php echo $this->bflibs->web_tool("publish",$module,array('id'=>$member_income_id,'status'=>$list['member_income_publish']),'publish_income','','list_income',$target,$pagination);?>
				<?php echo $this->bflibs->web_tool("up",$module,array('id'=>$list['member_income_id'],'seq'=>$list['member_income_seq']),'up_income',$param,'list_income',$target);?>
				<?php echo $this->bflibs->web_tool("down",$module,array('id'=>$list['member_income_id'],'seq'=>$list['member_income_seq']),'down_income',$param,'list_income',$target);?>
				<?php //echo $this->bflibs->web_tool("edit",$module,array('id'=>$list['member_income_id']),'edit_income');?>
                <a class="edit edit_income" row-data="income_name_<?php echo $member_income_id;?>" href="javascript:void(0)" title="แก้ไข"></a>
				<?php echo $this->bflibs->web_tool("delete",$module,array('id'=>$list['member_income_id']),'delete_income',$param,'list_income',$target);?>
				
				
			</td>
		</tr>
		<?php }}else{?>
		<tr><td colspan="3" align="center"><?php echo lang('web_no_data');?></td></tr>
		<?php }?>
	</tbody>
</table>
<div class="clearfix"></div>
    
<style>
#showWarning_income .bar_success{ width: 85%; }
</style>

<script>
$(document).ready(function(){
	$('.edit_income').click(function(){
		box = $(this).attr('row-data');
		$('#box_'+box).slideToggle();
		$('#boxEdit_'+box).slideToggle();
	})
	$("#income_form").validate({
		rules: {
			'member_income_name' : {
				required: true,
			},
		},
	   	submitHandler: function(form) {
			document.income_formAdd.submit();
	 	}
	});
});
</script>
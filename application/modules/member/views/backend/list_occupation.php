<?php $pagination = false;
$this->model = $this->load->model('member/Membermodel');
?>

<div id="showWarning_occupation" style="height:40px; display:none;"></div>
<div class="fluid">
	<iframe frameborder="0" width="0" height="0" id="myIframe_occupation" name="myIframe_occupation"></iframe>
	<form class="formElement" method="post" id="occupation_form" name="occupation_formAdd" target="myIframe_occupation" action="<?php echo DIR_ROOT?>member/backend/add_occupation">
        <div class="widget">
            <div class="formRow">
                <div class="grid2">
                    <label class="lbl fl" for="member_occupation_name"><?php echo lang('member_occupation_name');?></label>
                </div>
                <div class="grid4">
                    <input type="text" id="member_occupation_name" name="member_occupation_name">
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
			<th><?php echo lang('member_occupation_name');?></th>
            <th align="center" width="180"><?php echo lang('web_tool');?></th> 
		</tr> 
	</thead>
	<tbody>
	<?php 
	if(!empty($listOccupation)){
		$no=0;
		foreach($listOccupation as $list){
			$member_occupation_id = $list["member_occupation_id"];
			?>
		<tr>
			<td align="center"><?php echo ++$no;?></td>
			<td>
            	<div id="box_occupation_name_<?php echo $member_occupation_id;?>">
					<strong><?php echo $list['member_occupation_name'];?></strong>
                </div>
            	<div id="boxEdit_occupation_name_<?php echo $member_occupation_id;?>" style="display:none;">
                	<iframe frameborder="0" width="0" height="0" id="myIframe_occupation_<?php echo $member_occupation_id;?>" name="myIframe_occupation_<?php echo $member_occupation_id;?>"></iframe>
					<form method="post" target="myIframe_occupation_<?php echo $member_occupation_id;?>" action="<?php echo DIR_ROOT?>member/backend/edit_occupation" style="margin-top: -18px;">
                		<input type="text" id="occupation_name_<?php echo $member_occupation_id;?>" name="member_occupation_name" value="<?php echo $list['member_occupation_name'];?>" style="width:70%;" />
                		<input type="hidden" name="member_occupation_id" value="<?php echo $member_occupation_id;?>" />
                        <input type="hidden" id="captcha" name="captcha" value=""></input>
                    	<input type="submit" class="button" value="<?php echo lang('web_save');?>"></input>
                    </form>
                </div>
			</td>
			<td align="center">
				<?php echo $this->bflibs->web_tool("publish",$module,array('id'=>$member_occupation_id,'status'=>$list['member_occupation_publish']),'publish_occupation','','list_occupation',$target,$pagination);?>
				<?php echo $this->bflibs->web_tool("up",$module,array('id'=>$list['member_occupation_id'],'seq'=>$list['member_occupation_seq']),'up_occupation',$param,'list_occupation',$target);?>
				<?php echo $this->bflibs->web_tool("down",$module,array('id'=>$list['member_occupation_id'],'seq'=>$list['member_occupation_seq']),'down_occupation',$param,'list_occupation',$target);?>
				<?php //echo $this->bflibs->web_tool("edit",$module,array('id'=>$list['member_occupation_id']),'edit_occupation');?>
                <a class="edit edit_occupation" row-data="occupation_name_<?php echo $member_occupation_id;?>" href="javascript:void(0)" title="แก้ไข"></a>
				<?php echo $this->bflibs->web_tool("delete",$module,array('id'=>$list['member_occupation_id']),'delete_occupation',$param,'list_occupation',$target);?>
				
				
			</td>
		</tr>
		<?php }}else{?>
		<tr><td colspan="3" align="center"><?php echo lang('web_no_data');?></td></tr>
		<?php }?>
	</tbody>
</table>
<div class="clearfix"></div>
    
<style>
#showWarning_occupation .bar_success{ width: 85%; }
</style>

<script>
$(document).ready(function(){
	$('.edit_occupation').click(function(){
		box = $(this).attr('row-data');
		$('#box_'+box).slideToggle();
		$('#boxEdit_'+box).slideToggle();
	})
	$("#occupation_form").validate({
		rules: {
			'member_occupation_name' : {
				required: true,
			},
		},
	   	submitHandler: function(form) {
			document.occupation_formAdd.submit();
	 	}
	});
});
</script>
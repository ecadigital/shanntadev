<?php //$pagination = true;
$this->model = $this->load->model('member/Membermodel');
?>
<table cellpadding="0" cellspacing="0" border="0" width="100%" class="data"> 
	<thead> 
		<tr> 
			<th align="center" width="50"><?php echo lang('web_no');?></th>
			<th align="center"><?php echo lang('member_name');?></th>
			<th align="center" width="15%">ชื่อผู้ใช้</th>
			<th align="center" width="100">รหัสผ่าน</th>
			<th align="center" width="15%">เบอร์โทรศัพท์</th>
			<th align="center" width="10%">ส่วนลด</th>
            <th align="center" width="130"><?php echo lang('web_tool');?></th> 
		</tr> 
	</thead>
	<tbody>
	<?php 
	if(!empty($listTeam)){
		$no=0;
		foreach($listTeam as $list){
			$team_id = $list["member_id"];
			?>
		<tr>
			<td align="center"><?php echo ++$no;?></td>
			<td><?php echo $list['member_first_name'].' '.$list['member_last_name'];?></td>
			<td align="center"><?php echo $list['member_email'];?></td>
			<td align="center"><?php echo base64_decode($list['member_pass']);?></td>
			<td align="center"><?php echo $list['member_tel'];?></td>
			<td align="center"><?php if($list['member_discount']!='') echo $list['member_discount'].'%';?></td>
			<td align="center">
            	<a href="<?php echo DIR_ROOT?>member/backend/index_history/id/<?php echo $team_id;?>" title="History"><img src="<?php echo DIR_PUBLIC?>layout/default/images/shopping.png" alt=""></a>&nbsp;&nbsp;&nbsp;
                <!--<a href="javascript:void(0)" onclick="showEditTeam('<?php echo $team_id;?>')" title="แก้ไข" class="edit"></a>-->
				<?php echo $this->bflibs->web_tool("edit",$module,array('id'=>$team_id),'edit_team');?>
				<?php //echo $this->bflibs->web_tool("delete",$module,array('id'=>$list['member_id']),'delete_member',$param,'list_member',$target);?>
			</td>
		</tr>
		<?php }}else{?>
		<tr><td colspan="3" align="center"><?php echo lang('web_no_data');?></td></tr>
		<?php }?>
	</tbody>
</table>
<div class="clearfix"></div>
<?php //echo $page_description.$paginaion;?>
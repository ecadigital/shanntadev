<?php $pagination = true;
$this->model = $this->load->model('member/Membermodel');
?>
<table cellpadding="0" cellspacing="0" border="0" width="100%" class="data"> 
	<thead> 
		<tr> 
			<th align="center" width="50"><?php echo lang('web_no');?></th>
			<th align="center" width="100">ประเภทสมาชิก</th>
			<th align="center"><?php echo lang('member_name');?></th>
			<th align="center" width="15%">รายชื่อลูกค้า</th>
			<th align="center" width="130">ชื่อผู้ใช้</th>
			<th align="center" width="100">รหัสผ่าน</th>
			<th align="center" width="130"><?php echo lang('member_tel');?></th>
			<th align="center" width="130"><?php echo lang('member_update');?></th>
            <th align="center" width="100"><?php echo lang('web_tool');?></th> 
		</tr> 
	</thead>
	<tbody>
	<?php 
	if(!empty($listMember)){
		$no=($page-1)*$limit;
		foreach($listMember as $list){
			$member_id = $list["member_id"];
			$member_publish = $list["member_publish"];
			$countTeam = $this->model->countTeam($member_id);
			$listTeam = $this->model->listTeam($member_id);
			?>
		<tr <?php if($member_publish==0){?> style="background-color: #FFB0B0;"<?php }?>>
			<td align="center"><?php echo ++$no;?></td>
			<td align="center"><?php echo ($list["member_type"]==1) ? 'เอเยนต์' : 'สมาชิกขาจร';?></td>
			<td>
				<div><a href="<?php echo DIR_ROOT?>member/backend/edit_member/id/<?php echo $member_id;?>" class="bluesky"><strong><?php echo $list['member_first_name'];?> <?php echo $list['member_last_name'];?></strong></a> (แต้มสะสม <a href="<?php echo DIR_ROOT?>member/backend/index_point/id/<?php echo $list['member_id']; ?>"><?php echo number_format($list['member_point']); ?></a>)</div>
                <!--<div>จำนวนลูกค้า : <a href="<?php echo DIR_ROOT?>member/backend/index_team/id/<?php echo $list['member_id']; ?>" class="bluesky"><strong><?php echo $countTeam;?></strong></a></div>-->
                <?php if($list["member_code"]!='') echo '<div><i>Code : '.$list["member_code"].'</i></div>';?>
                <?php if($list["member_discount"]!='') echo '<div><i>ได้รับส่วนลด '.$list["member_discount"].'%</i></div>';?>
            </td>
			<td>
				<?php 
				$noTeam = 0;
				if(!empty($listTeam)){
					foreach($listTeam as $team){
						$noTeam++;
						echo '<div>'.$noTeam.'. '.$team['member_first_name'].' '.$team['member_last_name'].'</div>';
					}
				}
				?>
                <div style="float:right;"><a href="<?php echo DIR_ROOT?>member/backend/index_team/id/<?php echo $list['member_id']; ?>" class="bluesky"><strong>ข้อมูลลูกค้า</strong></a></div>
            </td>
			<td align="center"><?php echo $list['member_email'];?></td>
			<td align="center"><?php echo base64_decode($list['member_pass']);?></td>
			<td align="center">
            	<div><?php /*?><?php echo lang('member_tel');?> : <?php */?><?php echo $list['member_tel'];?></div>
            	<?php /*?><div><?php echo lang('member_mobile');?> : <?php echo $list['member_mobile'];?></div><?php */?>
            </td>
            <td align="center"><?php echo $this->bflibs->timeString($list['member_date_added']);?></td>
			<td align="center">
            	<?php if($member_publish==1){?>
                    <a href="<?php echo DIR_ROOT?>member/backend/index_order/id/<?php echo $member_id;?>" title="แก้ไข"><img src="<?php echo DIR_PUBLIC?>layout/default/images/shopping.png" alt=""></a>&nbsp;&nbsp;&nbsp;
                    <?php echo $this->bflibs->web_tool("edit",$module,array('id'=>$list['member_id']),'edit_member');?>
                    <?php echo $this->bflibs->web_tool("delete",$module,array('id'=>$list['member_id']),'delete_member',$param,'list_member',$target);?>
				<?php }else{?>
                    <?php //echo $this->bflibs->web_tool("publish",$module,array('id'=>$member_id,'status'=>$list['member_publish']),'publish_member','','list_member',$target,$pagination);?>
                    <a onclick="loadAjax('/member/backend/publish_member/id/<?php echo $member_id;?>/status/0','','loadPage(\'/member/backend/list_member\',\'#boxContent\')')" href="javascript:void(0);" title="ยืนยันให้เข้าใช้งาน">ยืนยันให้เข้าใช้งาน</a>
                	<!--<a href="<?php echo DIR_ROOT?>member/backend/member_confirm/id/<?php echo $member_id;?>" title="ยืนยัน">ยืนยันให้เข้าใช้งาน</a>-->
                <?php }?>
				
			</td>
		</tr>
		<?php }}else{?>
		<tr><td colspan="4" align="center"><?php echo lang('web_no_data');?></td></tr>
		<?php }?>
	</tbody>
</table>
<div class="clearfix"></div>
<?php echo $page_description.$paginaion;?>
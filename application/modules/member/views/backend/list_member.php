<?php $pagination = true;
$this->model = $this->load->model('member/Membermodel');
?>
<table cellpadding="0" cellspacing="0" border="0" width="100%" class="data"> 
	<thead> 
		<tr> 
			<th align="center" width="50"><?php echo lang('web_no');?></th>
			<th align="center">ชื่อ-นามสกุล</th>
			<th align="center" width="130">อีเมล์</th>
			<!--<th align="center" width="100">รหัสผ่าน</th>-->
			<th align="center" width="130">เบอร์โทรศัพท์</th>
			<th align="center" width="130">วันที่อัพเดต</th>
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
			?>
		<tr <?php if($member_publish==0){?> style="background-color: #FFB0B0;"<?php }?>>
			<td align="center"><?php echo ++$no;?></td>
			<td><a href="<?php echo DIR_ROOT?>member/backend/edit_member/id/<?php echo $member_id;?>" class="bluesky"><strong><?php echo $list['member_first_name'];?> <?php echo $list['member_last_name'];?></strong></a> 
			</td>
			<td align="center"><?php echo $list['member_email'];?> <?php echo base64_decode($list['member_pass']);?></td>
			<td align="center"><?php echo $list['member_phone'];?></td>
            <td align="center"><?php echo $this->bflibs->timeString($list['member_date_added']);?></td>
			<td align="center">
            	<?php if($member_publish==1){?>
                    <a href="<?php echo DIR_ROOT?>member/backend/index_order/id/<?php echo $member_id;?>" title="ดูรายการสั่งซื้อ"><img src="<?php echo DIR_PUBLIC?>layout/default/images/shopping.png" alt=""></a>&nbsp;&nbsp;&nbsp;
                    <?php echo $this->bflibs->web_tool("publish",$module,array('id'=>$list['member_id'],'status'=>$list['member_publish']),'publish_member',$param,'list_member',$target);?>
                    <?php //echo $this->bflibs->web_tool("edit",$module,array('id'=>$list['member_id']),'edit_member');?>
                    <?php //echo $this->bflibs->web_tool("delete",$module,array('id'=>$list['member_id']),'delete_member',$param,'list_member',$target);?>
				<?php }else{?>
					<a href="<?php echo DIR_ROOT?>member/backend/index_order/id/<?php echo $member_id;?>" title="ดูรายการสั่งซื้อ"><img src="<?php echo DIR_PUBLIC?>layout/default/images/shopping.png" alt=""></a>&nbsp;&nbsp;&nbsp;
                    <?php echo $this->bflibs->web_tool("publish",$module,array('id'=>$member_id,'status'=>$list['member_publish']),'publish_member','','list_member',$target,$pagination);?>
                    <!--<a onclick="loadAjax('/member/backend/publish_member/id/<?php echo $member_id;?>/status/0','','loadPage(\'/member/backend/list_member\',\'#boxContent\')')" href="javascript:void(0);" title="ยืนยันให้เข้าใช้งาน">ยืนยันให้เข้าใช้งาน</a>-->
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
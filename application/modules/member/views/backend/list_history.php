<?php $pagination = true;
$this->model = $this->load->model('member/Membermodel');
?>
<table cellpadding="0" cellspacing="0" border="0" width="100%" class="data"> 
	<thead> 
		<tr> 
			<th align="center" width="7%"><?php echo lang('web_no');?></th>
			<th align="center" width="8%">รหัสการสั่งซื้อ</th>
            <th align="center">ชื่อ</th> 
            <th align="center" width="10%">วันที่สั่งซื้อ</th>
            <th align="center" width="10%">เป็นเงิน</th>
            <th align="center" width="10%">สถานะ</th>
            <th align="center" width="12%">Tracking Number</th>
            <th align="center" width="50"><?php echo lang('web_tool');?></th>
		</tr> 
	</thead>
	<tbody>
	<?php 
	if(!empty($listHistory)){
		$no=($page-1)*$limit;
		foreach($listHistory as $list){
			$order_id = $list["order_id"];
			//อยู่ระหว่างรอการชำระเงิน, อยู่ระหว่างดำเนินการส่งสินค้า, การจัดส่งสินค้าเรียบร้อยแล้ว
			?>
		<tr>
			<td align="center"><?php echo ++$no;?></td>
			<td align="center"><a href="<?php echo DIR_ROOT?>shoppingcart/backend/view_order/id/<?php echo $list['order_id'];?>"><?php echo str_pad($list['order_id'],6,0,STR_PAD_LEFT);?></a></td>
			<td><?php echo $list['member_first_name']." ".$list['member_last_name'];?></td>
			<td align="center"><?php echo $this->bflibs->timeString($list['order_date'],'date');?></td>
			<td align="right">
				<?php 			
				if($list['order_payment']==2){
					$summary = $list['order_summary'];
					list($discount,$dis_type) = $this->model->getDiscount($list['order_discount']);
					$summary = ($dis_type==1) ? $summary*(100-$list['order_discount'])/100 : $summary-$list['order_discount'];
					echo '<div><strong>'.number_format($summary,2).'</strong></div>';
					if($list['order_discount']!='' && $list['order_discount']!='%') echo '<div><i>ส่วนลด '.$list['order_discount'].'</i></div>';
				}else{
					echo number_format($list['order_summary'],2);
				}
				?>
            </td>
			<td align="center">
				<select name="order_status" id="order_status" class="select_order" order-id="<?php echo $order_id;?>" 
                <?php if($list['order_status_id']==1) echo 'style="color:blue;"';
						if($list['order_status_id']==2) echo 'style="color:orange;"';
						if($list['order_status_id']==3) echo 'style="color:green;"';?>>
					<option value="1" <?php echo ($list['order_status_id']==1)?'selected="selected"':'';?> style="color:blue;">อยู่ระหว่างรอการชำระเงิน</option>
					<option value="2" <?php echo ($list['order_status_id']==2)?'selected="selected"':'';?> style="color:orange;">อยู่ระหว่างดำเนินการส่งสินค้า</option>
					<option value="3" <?php echo ($list['order_status_id']==3)?'selected="selected"':'';?> style="color:green;">การจัดส่งสินค้าเรียบร้อยแล้ว</option>
                </select>
                <?php //if(!empty($getOrderConfirm)) echo '<div style="margin-top:5px;"><a onclick="myAlert(\''.$txt_confirm.'\')" href="javascript:void(0);">ดูรายละเอียดยืนยันการชำระเงิน</a></div>';?>
                <div id="ok_<?php echo $order_id;?>" style="display:none;position:relative; left:-10px;top:5px; color:#060;"><img src="<?php echo DIR_PUBLIC?>layout/admin/images/oke.png" /> บันทึกเรียบร้อย</div>
            </td>
			<td align="center">
                <div id="boxTracking_<?php echo $order_id;?>" <?php echo ($list['order_status_id']==3)?'':'style="display:none;"';?>>
                    <input type="text" name="tracking_<?php echo $order_id;?>" id="tracking_<?php echo $order_id;?>" value="<?php echo $list['order_tracking'];?>" placeholder="เลข Tracking Number" style="width:120px; text-align:center;" />
                    <div style="margin-top:5px;"><input type="button" class="button button_tracking" value="ตกลง" order-id="<?php echo $order_id;?>"></input></div>
                	<div id="okt_<?php echo $order_id;?>" style="display:none;position:relative; left:-10px;top:5px; color:#060;"><img src="<?php echo DIR_PUBLIC?>layout/admin/images/oke.png" /> บันทึกเรียบร้อย</div>
                </div>
            </td>
			<td align="center">
				<?php //echo $this->bflibs->web_tool("publish",$module,array('id'=>$order_id,'status'=>$list['order_read']),'order_read','','list_order',$target,$pagination);?>
				<?php //echo $this->bflibs->web_tool("edit",$module,array('id'=>$order_id),'edit_order');?>
				<?php echo $this->bflibs->web_tool("delete",$module,array('id'=>$order_id),'delete_order',$param,'list_order',$target);?>
            </td>
		</tr>
		<?php }}else{?>
		<tr><td colspan="8" align="center"><?php echo lang('web_no_data');?></td></tr>
		<?php }?>
	</tbody>
</table>
<div class="clearfix"></div>
<?php echo $page_description.$paginaion;?>
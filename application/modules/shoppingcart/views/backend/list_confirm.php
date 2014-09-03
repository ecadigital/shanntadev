<?php $pagination = true;
?>
<table cellpadding="0" cellspacing="0" border="0" width="100%" class="data"> 
	<thead> 
		<tr> 
			<th align="center" width="5%"><?php echo lang('web_no');?></th>
			<!--<th align="center" width="10%">รหัสสั่งซื้อ</th>-->
            <th align="center" width="15%">ชื่อ-นามสกุล</th>
            <th align="center" width="10%">เบอร์โทรศัพท์</th> 
            <th align="center" width="12%">ชำระเข้าธนาคาร </th>
            <th align="center" width="12%">จำนวนเงิน </th>
            <th align="center" width="12%">วันที่ชำระเงิน </th>
            <th align="center">หมายเหตุ </th>
            <th align="center" width="70"><?php echo lang('web_tool');?></th>
		</tr> 
	</thead>
	<tbody>
	<?php 
	if(!empty($listConfirm)){
		$no=($page-1)*$limit;
		foreach($listConfirm as $list){
			$order_confirm_id = $list["order_confirm_id"];
			$bank = $this->model->listEditBank($list['order_confirm_bank']);
			?>
		<tr>
			<td align="center"><?php echo ++$no;?></td>
			<!--<td align="center">Order #<?php echo $list['order_id'];?></td>-->
			<td align="center"><?php echo $list['order_confirm_name'].' '.$list['order_confirm_surname'];?></td>
			<td align="center"><?php echo $list['order_confirm_tel'];?></td>
			<td align="center"><?php echo (empty($bank)) ? '' : $bank['bank_name'];?></td>
			<td align="center"><?php echo number_format($list['order_confirm_total']);?></td>
			<td align="center"><?php echo $list['order_confirm_transfer_date'].' น.';?></td>
			<td align="center"><?php echo nl2br($list['order_confirm_note']);?></td>
			<td align="center">
				<?php echo $this->bflibs->web_tool("delete",$module,array('id'=>$list['order_confirm_id']),'delete_confirm',$param,'list_confirm',$target);?>
            </td>
		</tr>
	<?php }}else{?>
		<tr><td colspan="8" align="center"><?php echo lang('web_no_data');?></td></tr>
	<?php }?>
	</tbody>				  
</table>
<?php echo $page_description.$paginaion;?>
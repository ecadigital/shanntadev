<?php 
$this->model = $this->load->model('voucher/Vouchermodel');
?>
<table cellpadding="0" cellspacing="0" border="0" width="100%" class="data"> 
	<thead> 
		<tr> 
			<th align="center" width="50"><?php echo lang('web_no');?></th>
			<th align="center">เลข Voucher</th>
			<th align="center" width="20%">เบอร์โทร</th>
			<th align="center" width="20%">จำนวนแต้มที่เพิ่ม</th>
            <th align="center" width="150"><?php echo lang('web_tool');?></th>
		</tr> 
	</thead>
	<tbody>
	<?php if(!empty($listVoucher)){
		$no = 0;
		foreach($listVoucher as $list){
			$voucher_id = $list['voucher_id'];?>
            <tr>
                <td align="center"><?php echo ++$no;?></td>
                <td align="center"><?php echo $list['voucher_no']?></td>
                <td align="center"><?php echo $list['voucher_tel']?></td>
                <td align="center"><?php echo $list['voucher_point']?></td>
                <td align="center">
                    <?php //echo $this->bflibs->web_tool("publish",$module,array('id'=>$voucher_id,'status'=>$list['voucher_publish']),'publish_voucher',$param,'list_voucher',$target);?>
                    <?php //echo $this->bflibs->web_tool("edit",$module,array('id'=>$voucher_id),'edit_voucher');?>
                    <?php echo $this->bflibs->web_tool("delete",$module,array('id'=>$voucher_id),'delete_voucher',$param,'list_voucher',$target);?>
                </td>
            </tr>
		<?php }}else{?>
		<tr><td colspan="5" align="center"><?php echo lang('web_no_data');?></td></tr>
		<?php }?>
	</tbody>
</table>
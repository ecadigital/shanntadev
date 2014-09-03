<?php $pagination = true;
$this->model = $this->load->model('member/Membermodel');
?>
<table cellpadding="0" cellspacing="0" border="0" width="100%" class="data"> 
	<thead> 
		<tr> 
			<th align="center" width="50"><?php echo lang('web_no');?></th>
			<th align="center" width="15%">เลขที่สั่งซื้อ</th>
			<th align="center">ชื่อสินค้า</th>
			<th align="center" width="15%">จำนวน</th>
			<th align="center" width="15%">ราคา</th>
			<th align="center" width="15%">ชำระโดย</th>
			<th align="center" width="15%">วันที่ซื้อสินค้า</th>
            <!--<th align="center" width="130"><?php echo lang('web_tool');?></th> -->
		</tr> 
	</thead>
	<tbody>
	<?php 
	if(!empty($listHistory)){
		$no=($page-1)*$limit;
		foreach($listHistory as $list){
			//$order_item_id = $list["order_item_id"];
			?>
		<tr>
			<td align="center"><?php echo ++$no;?></td>
			<td align="center">Order #<?php echo $list['order_id'];?></td>
			<td><?php echo $list['product_name'];?></td>
			<td align="right"><?php echo $list['order_qty'];?></td>
			<td align="center"><?php echo ($list['order_payment']==1) ? number_format($list['order_point']).' แต้ม' : number_format($list['order_price'],2).' บาท';?></td>
			<td align="center"><?php echo ($list['order_payment']==1) ? 'หักแต้มสะสม' : 'โอนเงิน';?></td>
			<td align="center"><?php echo date("d/m/Y",strtotime($list['order_date']));?></td>
			<?php /*?><td align="center">
            	<a href="<?php echo DIR_ROOT?>member/backend/history/id/<?php echo $member_id;?>" title="แก้ไข"><img src="<?php echo DIR_PUBLIC?>layout/default/images/shopping.png" alt=""></a>&nbsp;&nbsp;&nbsp;
				<?php echo $this->bflibs->web_tool("publish",$module,array('id'=>$member_id,'status'=>$list['member_publish']),'publish_member','','list_member',$target,$pagination);?>
				<?php echo $this->bflibs->web_tool("edit",$module,array('id'=>$list['member_id']),'edit_member');?>
				<?php echo $this->bflibs->web_tool("delete",$module,array('id'=>$list['member_id']),'delete_member',$param,'list_member',$target);?>
				
				
			</td><?php */?>
		</tr>
		<?php }}else{?>
		<tr><td colspan="5" align="center"><?php echo lang('web_no_data');?></td></tr>
		<?php }?>
	</tbody>
</table>
<div class="clearfix"></div>
<?php echo $page_description.$paginaion;?>
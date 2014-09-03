<?php 
$this->model = $this->load->model('shoppingcart/Shoppingcart_frontmodel');
$this->modelMem = $this->load->model('member/Member_frontmodel');
?>
<!--<link type="text/css" rel="stylesheet" href="<?php echo DIR_PUBLIC;?>layout/default/css/_groundwork.css">-->
<script type="text/javascript" src="<?php echo DIR_PUBLIC;?>layout/default/js/groundwork.all.js"></script>
<script type="text/javascript" src="<?php echo DIR_PUBLIC;?>module/shoppingcart/frontend/js/function.js"></script>


<table class="responsive">
	<thead>
		<tr>
			<th data-width="55%" style="background-color:#f2f2f2!important; color:#666666;"><center>สินค้า</center></th>
			<th data-width="10%" style="background-color:#f2f2f2!important; color:#666666;"><center>จำนวน</center></th>
			<th data-width="13%" style="background-color:#f2f2f2!important; color:#666666;"><center>ราคา (ทั้งหมด)</center></th>
			<th data-width="13%" style="background-color:#f2f2f2!important; color:#666666;"><center>แต้ม (ทั้งหมด)</center></th>
            <th data-width="10%" style="background-color:#f2f2f2!important; color:#666666;"><center>ชำระโดย</center></th>
			<th data-width="15%" style="background-color:#f2f2f2!important; color:#666666;"><center>สถานะ</center></th>
		</tr>
	</thead>
	<tbody>
    	<?php 
		$arrList = mysql_query("SELECT * FROM sp_order WHERE order_id='".$id."' ");
		if(mysql_num_rows($arrList)>0){
			$order = mysql_fetch_array($arrList);
					
			$order_status_id = $order['order_status_id'];
			$order_tracking = $order['order_tracking'];
			$member_discount = $order['order_discount'];
			$order_payment = $order['order_payment'];
			
			$txt_order_payment = '';
			if($order_payment==1) $txt_order_payment = 'หักจากแต้มสะสม';
			if($order_payment==2) $txt_order_payment = 'โอนเงิน';
			
			$txt_payment = '';
			//อยู่ระหว่างรอการชำระเงิน, อยู่ระหว่างดำเนินการส่งสินค้า, การจัดส่งสินค้าเรียบร้อยแล้ว
			if($order_payment==1) $txt_payment = '<span style="color:orange;">อยู่ระหว่างดำเนินการส่งสินค้า</span>';
			//if($order_payment==2) $txt_payment = '<a href="payment_confirmation.php?order='.$id.'">ยืนยันการชำระเงิน</a>';
			
			if($order_status_id==2) $txt_payment = '<span style="color:orange;">อยู่ระหว่างดำเนินการส่งสินค้า</span>';
			else if($order_status_id==3) $txt_payment = '<span style="color:green;">การจัดส่งสินค้าเรียบร้อยแล้ว </span>';
			else $txt_payment = '<span style="color:red;">อยู่ระหว่างรอการชำระเงิน</span>';
			
			$countOrderConfirm = $this->modelMem->countOrderConfirm($id);
			if($countOrderConfirm>0) $txt_payment = '<span style="color:orange;">อยู่ระหว่างดำเนินการส่งสินค้า</span>';
			
			$sum_qty = 0;
			$sum_price = 0;
			$sum_point = 0;
	
			$arrList = mysql_query("SELECT * FROM sp_order_item WHERE order_id='".$id."' ");
			if(mysql_num_rows($arrList)>0){
				while($list = mysql_fetch_array($arrList)){
					$qty = $list['order_qty'];
					$price = $list['order_price'];
					$total_price = $price*$qty;
					$point = $list['order_point'];
					$total_point = $point*$qty;
					
					$sum_qty += $qty;
					$sum_price += $total_price;
					$sum_point += $total_point;
					
					$img_path = DIR_PUBLIC."layout/default/images/empty.png";
					
					$arrImg = mysql_query("SELECT product_images_path FROM product_images 
													WHERE product_id='".$list['product_id']."' ORDER BY product_images_seq ASC LIMIT 1");
					if(mysql_num_rows($arrImg)>0){
						$listImg = mysql_fetch_array($arrImg);
						$img_db = $listImg["product_images_path"];
						if($img_db!=''){
							$path = "public/upload/product/thumbnails/".basename($img_db);
							$dir_file = DIR_FILE.$path;
							if(file_exists($dir_file)){
								$img_path = DIR_ROOT.$path;
							}
						}
					}
					echo '
					<tr>
						<td>
						<img src="'.$img_path.'" alt="" class="pull-left gap-right gap-bottom">
						<h6>'.$list['product_name'].'</h6>
						<p class="truncate">'.$list['product_detail'].'</p>
						</td>
						<td><center>'.number_format($qty).'</center></td>
						<td><center>'.number_format($price).' ('.number_format($total_price).')</center></td>
						<td><center>'.number_format($point).' ('.number_format($total_point).')</center></td>
						<td></td>
						<td></td>
					</tr>';
				}
			}
		}
		?>
	</tbody>
	<tfoot>
		<tr>
			<td><center><b>ทั้งหมด</b></center></td>
			<td><b><center><?php echo number_format($sum_qty);?> ชิ้น</center></b></td>
			<td><b><center><?php echo number_format($sum_price);?> บาท</center></b></td>
			<td><b><center><?php echo number_format($sum_point);?> แต้ม</center></b></td>
			<td><b><center><?php echo $txt_order_payment;?></center></b></td>
			<td><b><center><?php echo $txt_payment;?></center></b></td>
			<td></td>
		</tr>
	</tfoot>
</table>

<div style="margin-top:20px; line-height:40px;">
	<div style="float:left;">
        <strong>ที่อยู่ในการจัดส่ง</strong><br/>
        <!--ชื่อ --><?php echo $order['member_first_name'].' '.$order['member_last_name'];?><br/>
        <!--ที่อยู่ --><?php echo $order['member_address'];?><br/>
        โทร. <?php echo $order['member_tel'];?>
    </div>
    <div style="float:left; margin-left:100px;">Your Tracking Number : <?php echo ($order_tracking=='') ? '-' : $order_tracking;?></div>
</div>
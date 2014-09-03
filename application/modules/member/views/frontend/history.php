<?php 
$this->model = $this->load->model('member/Member_frontmodel');
$this->modelCart = $this->load->model('shoppingcart/Shoppingcart_frontmodel');

if(!empty($listOrder)){
	foreach($listOrder as $list){
		
		$member_id = $list['member_id'];
		$order_id = $list['order_id'];
		$order_status_id = $list['order_status_id'];
		$order_tracking = $list['order_tracking'];
		$member_discount = $list['order_discount'];
		$order_payment = $list['order_payment'];
		
		$txt_order_payment = '';
		if($order_payment==1) $txt_order_payment = 'หักจากแต้มสะสม';
		if($order_payment==2) $txt_order_payment = 'โอนเงิน';
		
		$txt_payment = '';
		//อยู่ระหว่างรอการชำระเงิน, อยู่ระหว่างดำเนินการส่งสินค้า, การจัดส่งสินค้าเรียบร้อยแล้ว
		if($order_payment==1) $txt_payment = '<span style="color:orange;">อยู่ระหว่างดำเนินการส่งสินค้า</span>';
		if($order_payment==2) $txt_payment = '<a href="payment_confirmation.php?order='.$order_id.'">ยืนยันการชำระเงิน</a>';
		
		if($order_status_id==2) $txt_payment = '<span style="color:orange;">อยู่ระหว่างดำเนินการส่งสินค้า</span>';
		if($order_status_id==3) $txt_payment = '<span style="color:green;">การจัดส่งสินค้าเรียบร้อยแล้ว </span><div style="margin-left:60px;">(Tracking : '.$order_tracking.')</div>';
		
		$countOrderConfirm = $this->model->countOrderConfirm($order_id);
		if($countOrderConfirm>0) $txt_payment = '<span style="color:orange;">อยู่ระหว่างดำเนินการส่งสินค้า</span>';
		
		$sum_qty = 0;
		$sum_price = 0;
		$sum_point = 0;

		?>
        <table class="responsive" style=" border:none;">
            <thead>
                <tr>
                    <th width="10%" style="background-color:#fff!important; color:#666666;">Order #<?php echo $order_id;?></th>
                    <th width="20%" style="background-color:#fff!important; color:#666666;">วันที่ : <?php echo date("d/m/Y",strtotime($list['order_date']));?></th>
                    <th width="20%" style="background-color:#fff!important; color:#666666;">ชำระโดย : <?php echo $txt_order_payment;?></th>
                    <th width="20%" style="background-color:#fff!important; color:#666666;">สถานะ : <?php echo $txt_payment;?></th>
                </tr>
            </thead>
            <tbody>
            	<tr>
                	<td colspan="4">
                        <table>
                            <thead>
                                <tr>
                                    <th data-width="55%" style="background-color:#f2f2f2!important; color:#666666;"><center>สินค้า</center></th>
                                    <th data-width="15%" style="background-color:#f2f2f2!important; color:#666666;"><center>จำนวน</center></th>
                                    <th data-width="15%" style="background-color:#f2f2f2!important; color:#666666;"><center>ราคา (ทั้งหมด)</center></th>
                                    <th data-width="15%" style="background-color:#f2f2f2!important; color:#666666;"><center>แต้ม (ทั้งหมด)</center></th>
                                </tr>
                            </thead>
                            <tbody>
                            	<?php 
								$no=0;
								$listOrderItem = $this->model->listOrderItem($order_id);
								if(!empty($listOrderItem)){
									foreach($listOrderItem as $item){
										$no++;
										$product_id = $item['product_id'];
										$product = $this->modelCart->getProduct($product_id);
										
										$qty = $item['order_qty'];
										$price = $item['order_price'];
										$total_price = $price*$qty;
										$point = $item['order_point'];
										$total_point = $point*$qty;
										
										if($member_discount!=''){
											$price = $price*((100-$member_discount)/100);
											$point = $point*((100-$member_discount)/100);
											$total_price = $total_price*((100-$member_discount)/100);
											$total_point = $total_point*((100-$member_discount)/100);
										}
										
										$sum_qty += $qty;
										$sum_price += $total_price;
										$sum_point += $total_point;
										
										$productImg = $this->modelCart->getProductImage($product_id);
										$img_path = DIR_PUBLIC."images/noimage.png";
										if(isset($productImg['product_images_path'])&&$productImg['product_images_path']!=''){
											$path = "public/upload/product/thumbnails/".basename($productImg['product_images_path']);
											$dir_file = DIR_FILE.$path;
											if(file_exists($dir_file)){
												$img_path = DIR_ROOT.$path;
											}
										}
                                        echo '
                                        <tr id="row_'.$order_id.'_'.$product_id.'" class="row">
											<td>
												<img src="'.$img_path.'" alt="" class="pull-left gap-right gap-bottom"/>
												<h6>'.$product['product_name'].'</h6>
												<p class="truncate">'.$product['product_detail'].'</p>
											</td>
											<td><center>'.$qty.'</center></td>
											<td><center>'.number_format($price).' (<span class="total_price">'.number_format($total_price).'</span>)</center></td>
											<td><center>'.number_format($point).' (<span class="total_point">'.number_format($total_point).'</span>)</center></td>
										</tr>';
                                    }
                                }else{
                                    echo '<tr><td colspan="4">ไม่พบข้อมูล</td></tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
		<?php 
	}
}
?>
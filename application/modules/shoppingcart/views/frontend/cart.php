<?php $this->model = $this->load->model('shoppingcart/Shoppingcart_frontmodel');?>
<!--<link type="text/css" rel="stylesheet" href="<?php echo DIR_PUBLIC;?>layout/default/css/_groundwork.css">-->
<script type="text/javascript" src="<?php echo DIR_PUBLIC;?>layout/default/js/groundwork.all.js"></script>
<script type="text/javascript" src="<?php echo DIR_PUBLIC;?>module/shoppingcart/frontend/js/function.js"></script>
<iframe frameborder="0" width="0" height="0" id="myIframe_cart" name="myIframe_cart"></iframe>

<?php 
$sum_qty = 0;
$sum_price = 0;
$sum_point = 0;

if(!empty($contents)){
	?>
    <form class="formElement" method="post" id="form_cart" name="form_cart" target="myIframe_cart" action="<?php echo DIR_ROOT?>shoppingcart/frontend/checkout">
    <table class="responsive" id="shopping-cart">
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
			foreach($contents as $content){
				$product = $this->model->getProduct($content['id']);
				$qty = $content['qty'];
				$price = $product['product_price'];
				$total_price = $price*$qty;
				$point = $product['product_point'];
				$total_point = $point*$qty;
				
				$member_id = (isset($_SESSION['member_id'])) ? $_SESSION['member_id'] : 0;
				$member_discount = $this->model->get_member_discount($member_id);
				if($member_discount!=''){
					$price = $price*((100-$member_discount)/100);
					$point = $point*((100-$member_discount)/100);
					$total_price = $total_price*((100-$member_discount)/100);
					$total_point = $total_point*((100-$member_discount)/100);
				}
				
				$sum_qty += $qty;
				$sum_price += $total_price;
				$sum_point += $total_point;
				
				$productImg = $this->model->getProductImage($content['id']);
				$img_path = DIR_PUBLIC."images/noimage.png";
				if(isset($productImg['product_images_path'])&&$productImg['product_images_path']!=''){
					$path = "public/upload/product/thumbnails/".basename($productImg['product_images_path']);
					$dir_file = DIR_FILE.$path;
					if(file_exists($dir_file)){
						$img_path = DIR_ROOT.$path;
					}
				}
            	echo '
                <tr row-id="'.$content['rowid'].'" class="row">
					<td>
						<img src="'.$img_path.'" alt="" class="pull-left gap-right gap-bottom"/>
						<h6>'.$product['product_name'].'</h6>
						<p>'.$this->bflibs->getSubString(strip_tags($product['product_detail']),200).' ... <a href="product_detail.php?id='.$content['id'].'" target="_blank">อ่านต่อ</a></p><!-- class="truncate"-->
						
						<a href="javascript:void(0)" class="remove-cart"><img src="'.DIR_PUBLIC.'layout/default/images/delete.png" /></a>
					</td>
					<td>
						<center>
							<input type="text" class="qty" id="inp-qty" name="inp-qty['.$content['rowid'].']" value="'.$qty.'" style="width:20%!important; text-align:right;"/>
							<input type="hidden" class="price" value="'.$price.'" />
							<input type="hidden" class="point" value="'.$point.'" />
						</center>
					</td>
					<td><center>'.number_format($price).' (<span class="total_price">'.number_format($total_price).'</span>)</center></td>
					<td><center>'.number_format($point).' (<span class="total_point">'.number_format($total_point).'</span>)</center></td>
				</tr>';
			}
			?>
		</tbody>
		<tfoot>
			<tr>
				<td><center><b>ทั้งหมด</b></center></td>
				<td><b><center><span id="sum_qty"><?php echo number_format($sum_qty);?></span> ชิ้น</center></b></td>
				<td><b><center><span id="sum_price"><?php echo number_format($sum_price);?></span> บาท</center></b></td>
				<td><b><center><span id="sum_point"><?php echo number_format($sum_point);?></span> แต้ม</center></b></td>
			</tr>
		</tfoot>
	</table>
	</form>
<?php 
}else{
	echo 'ไม่พบข้อมูล'; 	
}
?>
<br/>
<div class="row">
<div align="right">
<a href="product.php"><button class="yellow right"><i class="icon-chevron-left medium"></i>&nbsp;&nbsp;กลับไปเลือกสินค้า</button></a>
<?php if(!empty($contents)){?><a href="checkout.php"><button class="blue right">ชำระค่าสินค้า&nbsp;&nbsp;<i class="icon-chevron-right medium"></i></button></a><?php }?>
</div>
</div>
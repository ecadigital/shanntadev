<?php if(empty($getOrder)){?>
	<div style="height:200px; text-align:center; margin-top:100px;"><?php echo lang('nodata');?></div>		
<?php }else{ ?>
<?php 
$this->model = $this->load->model('shoppingcart/Shoppingcart_frontmodel');
$this->modelProduct = $this->load->model('product/Product_frontmodel');
$this->modelMember = $this->load->model('member/Member_frontmodel');

$order_id = $getOrder['order_id'];
$member_title = $getOrder['member_title'];
$member_fname = $getOrder['member_first_name'];
$member_lname = $getOrder['member_last_name'];
$member_address = $getOrder['member_address'];
$member_city = $getOrder['member_city'];
$member_postcode = $getOrder['member_postcode'];
$member_payment = $getOrder['order_payment'];
$bank_id = $getOrder['bank_id'];

$name = lang($member_title).' '.$member_fname.' '.$member_lname;
$address = $member_address.' '.$member_city.' '.$member_postcode;

$summary = 0;
$shipping = $getOrder['order_shipping'];
?>
<link rel="stylesheet" type="text/css" href="<?php echo DIR_PUBLIC;?>module/shoppingcart/frontend/css/style.css">
<header>
	<div class="medium-4 columns">
		<h1>CONFIRMATION</h1>
	</div>
	<div class="medium-8 columns"><?php echo $this->model->nav_cart(5);?></div>
	<div class="clearfix"></div>
</header>
<form action="#" method="post">
	<div class="row">
		<div class="small-12 medium-6 medium-push-6 columns cart5">
			<div class="row">
				<div class="small-6 medium-5 columns">
					<h5><?php echo strtoupper(lang('ordernumber'));?></h5>
				</div>
				<div class="small-6 medium-7 columns">
					<h6><?php echo str_pad($order_id,6,0,STR_PAD_LEFT);?></h6>
				</div>
			</div>
			<div class="row">
				<div class="small-6 medium-5 columns">
					<h5><?php echo strtoupper(lang('paymentmethod'));?></h5>
				</div>
				<div class="small-6 medium-7 columns">
					<h6><?php echo lang($member_payment);?></h6>
				</div>
			</div>
			<div class="row">
				<div class="small-6 medium-5 columns">
					<h5><?php echo strtoupper(lang('shippingmethod'));?></h5>
				</div>
				<div class="small-6 medium-7 columns">
					<h6>Complimentary Starndard</h6>
				</div>
			</div>
			<div class="row">
				<div class="small-6 medium-5 columns">
					<h5><?php echo strtoupper(lang('deliveryaddress'));?></h5>
				</div>
				<div class="small-6 medium-7 columns">
					<h6><?php echo $name;?></h6>
					<span><?php echo $address;?></span>
				</div>
			</div>
			<div class="row">
				<div class="small-12 medium-5 columns">
					<h5><?php echo strtoupper(lang('productdetail'));?></h5>
				</div>
				<div class="small-12 medium-7 columns">
					<?php 
					$i=0;
					foreach($getOrderItem as $item){
						$product_id = $item['product_id'];
						$price = $item['order_price'];
						$qty = $item['order_qty'];
						$product = $this->modelProduct->getProduct($lang,$product_id);
						$name = $product["product_name"];
						$detail = $product["product_detail"];
						$img_db = $this->modelProduct->getFirstProductImage($product_id);
						
						
						$img_path = DIR_PUBLIC."images/noimage.png";
						if($img_db!=''){
							$path = "public/upload/product/thumbnails/".basename($img_db);
							$dir_file = DIR_FILE.$path;
							if(file_exists($dir_file)){
								$img_path = DIR_ROOT.$path;
							}
						}
						$i++;
						$total = $price*$qty;
						$summary += $total;
						echo '
						<div class="row">
							<div class="small-12 large-5 columns">
								<img src="'.$img_path.'" alt="">
							</div>
							<div class="small-12 large-7 columns">
								<h6>'.$name.'</h6>
								<div>Quantity : '.$qty.'</div>
							</div>
						</div>';
					}?>
				</div>
			</div>
			<?php 
			$currency = 'USD';
			if($lang==1) $currency = 'บาท';
			if($lang==3) $currency = 'CNY';
			?>
			<div class="row">
				<div class="small-6 medium-5 columns">
					<h5><?php echo strtoupper(lang('total'));?></h5>
				</div>
				<div class="small-6 medium-7 columns">
					<h6><?php echo number_format($summary+$shipping);?> <b><?php echo $currency;?></b></h6>
				</div>
			</div>
		</div>
		<div class="small-12 medium-6 medium-pull-6 columns">
		   <h2>THANK YOU FOR ORDER WITH SHANNTA.COM</h2>
		   <h3>A confirmation e-mail will be sent to you with all the relevant infomation regarding your purchase</h3>
		   <h3>Will your My Shannta account. you can track your order online. to find out more about the benefits of having a MyShannta on shannta.com </h3>
		   <div class="small-3 medium-5 large-4 columns"><a href="#" class="cabtn"><i class="fa fa-print"></i><b> PRINT</b></a></div>
	   </div>
	</div><!-- row -->
	<br>
	<div class="navigator">
		<div>
			<a href="index.php" class="button">Continue Shopping</a>
		</div>
	</div> <!-- .navigator -->
</form>

<script>
</script>
<?php }?>

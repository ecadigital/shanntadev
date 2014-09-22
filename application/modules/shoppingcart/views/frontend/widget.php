<?php 
$this->model = $this->load->model('shoppingcart/Shoppingcart_frontmodel');
$this->modelProduct = $this->load->model('product/Productmodel');
//
$total_items = $this->model->total_items();
$list_cart = $this->model->getCartRef();
$total = $this->model->total();

$action = $this->request->getActionName();

if($action=='message') $total_items=0;
?>
<a href="#" class=""><i class="fa fa-shopping-cart icon"></i> MY CART [5]</a>
<div class="sub selection">
	<div class="medium-7 columns head">Item</div>
	<div class="medium-2 columns head">Unit Price</div>
	<div class="medium-1 columns head">Qty.</div>
	<div class="medium-2 columns head">Cost</div>
	<div class="clearfix"></div>
	<?php 
	$i=0;
	foreach($contents as $content){
		$product_id = $content['id'];
		$product = $this->model->getProduct($product_id);
		$qty = $content['qty'];
		$price = $product['product_price'];
		$name = $product["product_name"];
		$detail = $product["product_detail"];
		$img_db = $this->model->getFirstProductImage($product_id);
		
		
		$img_path = DIR_PUBLIC."images/noimage.png";
		if($img_db!=''){
			$path = "public/upload/product/thumbnails/".basename($img_db);
			$dir_file = DIR_FILE.$path;
			if(file_exists($dir_file)){
				$img_path = DIR_ROOT.$path;
			}
		}
		$i++;
		echo '
		<div class="row ';if($i==1) echo 'first'; echo '">
			<div class="medium-2 columns">
				<img src="'.$img_path.'" alt="">
			</div>
			<div class="medium-5 columns">
				'.$name.'
				<a href="#">[Remove]</a>
			</div>
			<div class="medium-2 columns">
				'.number_format($price).' THB
			</div>
			<div class="medium-1 columns">
				<input type="text">
			</div>
			<div class="medium-2 columns ta-right">
				3,360 THB
			</div>
		</div>';
	}?>
	<div class="row">
		<div class="medium-3 medium-offset-6 columns"><b>Subtotal:</b></div> 
		<div class="medium-3 columns ta-right"><b>12,264 THB</b></div>
	</div>
	<div class="row">
		<div class="medium-3 medium-offset-6 columns"><b>Shipping:</b></div>
		<div class="medium-3 columns ta-right"><b>250 THB</b></div>
	</div>
	<div class="row">
		<div class="medium-3 medium-offset-6 columns"><b>Total:</b></div>
		<div class="medium-3 columns ta-right"><b>12,289 THB</b></div>
	</div>
	<div class="row">
		<div class="medium-4 medium-offset-8 columns ta-right">
			<a href="shipping.php" class="button">My Selection</a>
		</div>
	</div>
</div><!-- sub selection 


<a href="<?php echo DIR_ROOT;?>shoppingcart/frontend/cart" class="shoppingcart"><span href="" class="num">[<?php echo $total_items;?>]</span></a>-->
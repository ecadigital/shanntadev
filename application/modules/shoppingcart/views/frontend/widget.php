<?php 
$this->model = $this->load->model('shoppingcart/Shoppingcart_frontmodel');
$this->modelProduct = $this->load->model('product/Product_frontmodel');
//
$total_items = $this->model->total_items();
$list_cart = $this->model->getCartRef();
//$total = $this->model->total();
$summary = 0;
$shipping = 250;

//<a href="#" class=""><i class="fa fa-shopping-cart icon"></i> MY CART [5]</a>
//<div class="sub selection">-->
$Array_widget = array();

$Array_widget['widget_items'] = $total_items;

$Array_widget['widget_box'] = '
<form id="form_cart_widget">
	<div class="medium-7 columns head">'.lang('item').'</div>
	<div class="medium-2 columns head">'.lang('unitprice').'</div>
	<div class="medium-1 columns head">'.lang('qty').'</div>
	<div class="medium-2 columns head">'.lang('cost').'</div>
	<div class="clearfix"></div>';
	
	$i=0;
	foreach($contents as $content){
		$rowid = $content['rowid'];
		$product_id = $content['id'];
		$product = $this->modelProduct->getProduct($lang,$product_id);
		$qty = $content['qty'];
		$price = $product['product_price'];
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
		
		$Array_widget['widget_box'] .= '<div row-id="'.$rowid.'" class="row list_'.$i; 
		if($i==1) $Array_widget['widget_box'] .= ' first'; 
		$Array_widget['widget_box'] .= '">
			<div class="medium-2 columns">
				<img src="'.$img_path.'" alt="">
			</div>
			<div class="medium-5 columns">
				'.$name.'
				<a href="javascript:void(0)" class="wremove">['.lang('remove').']</a>
			</div>
			<div class="medium-2 columns">
				<span id="wprice_'.$i.'">'.number_format($price).'</span> '.lang('baht').'
			</div>
			<div class="medium-1 columns">
				<input type="text" class="wqty" id="wqty_'.$i.'" name="winp-qty['.$rowid.']" value="'.$qty.'" onkeyup="changeQty(\''.$i.'\')">
			</div>
			<div class="medium-2 columns ta-right">
				<span id="wtotal_'.$i.'">'.number_format($total).'</span> '.lang('baht').'
			</div>
		</div>';
	}
	$Array_widget['widget_box'] .= '
	<div class="row">
		<div class="medium-3 medium-offset-6 columns"><b>'.lang('subtotal').':</b></div> 
		<div class="medium-3 columns ta-right"><b><span id="wsubtotal">'.number_format($summary).'</span> '.lang('baht').'</b></div>
	</div>
	<div class="row">
		<div class="medium-3 medium-offset-6 columns"><b>'.lang('shipping').':</b></div>
		<div class="medium-3 columns ta-right"><b><span id="wshipping">'.number_format($shipping).'</span> '.lang('baht').'</b></div>
	</div>
	<div class="row">
		<div class="medium-3 medium-offset-6 columns"><b>'.lang('total').':</b></div>
		<div class="medium-3 columns ta-right"><b><span id="wsummary">'.number_format($summary+$shipping).'</span> '.lang('baht').'</b></div>
	</div>
	<div class="row">
		<div class="medium-4 medium-offset-8 columns ta-right">
			<a href="shipping.php" class="button">'.lang('myselection').'</a>
		</div>
	</div>
	<input type="hidden" name="numlist" id="numlist" value="'.$i.'" />
</form>
<script>
</script>';


echo json_encode($Array_widget);
?>
<?php 
$this->model = $this->load->model('shoppingcart/Shoppingcart_frontmodel');
$this->modelProduct = $this->load->model('product/Product_frontmodel');

$member_id = (isset($_SESSION['member_id'])) ? $_SESSION['member_id'] : '';

$summary = 0;
$shipping = 250;
?>
<header>
	<div class="medium-4 columns">
		<h1><?php echo strtoupper(lang('myselection'));?></h1>
	</div>
	<div class="medium-8 columns">
	</div>
	<div class="clearfix"></div>
</header>
<form action="#" method="post">

<?php if(empty($contents)){?>

	<div style="height:150px; text-align:center; margin-top:50px;"><?php echo lang('nodata');?></div>	
	
<?php }else{ ?>
	<div class="row productTable shipping">
		<table>
			<tr>
				<td>
					<h4><?php echo lang('product');?></h4>
				</td>
				<td class="medium-7">
					<h4><?php echo lang('description');?></h4>
				</td>
				<td>
					<h4><?php echo lang('price');?></h4>
				</td>
			</tr>
			<?php 
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
					
				echo '<tr '; if($i==1) echo 'class="first"'; echo '>
					<td class="image">
						<img src="'.$img_path.'" alt="">
					</td>
					<td>
						<h5>'.$name.'</h5>
						<div class="show-for-medium-up details">'.$detail.'</div>
					</td>
					<td>
						<div class="price"><span id="price_'.$i.'">'.number_format($price).'</span> <b>'.lang('baht').'</b></div>
					</td>
				</tr>';
			}?>
		</table>
		<hr class="review">
		<div class="small-12 columns optionalCheckbox">
			<br>
		</div>
		<div class="small-12 medium-4 columns total">
			<div class="small-4 columns"><?php echo lang('shipping');?></div>
			<div class="small-8 columns ta-right"> <span id="shipping"><?php echo number_format($shipping);?></span> <?php echo lang('baht');?></div>
			<div class="small-4 columns"><b><?php echo lang('total');?></b></div>
			<div class="small-8 columns ta-right"><b><span id="summary"><?php echo number_format($summary+$shipping);?></span> <?php echo lang('baht');?></b></div>
			<div class="clearfix"></div>
		</div>
	</div>
	<br>
	<div class="navigator">
		<div>
			<a href="<?php echo ($member_id=='') ? 'cart0.php' : 'cart2.php';?>" class="arrow_box right next"><?php echo lang('continue');?></a>
		</div>
	</div> <!-- .navigator -->
<?php }?>
</form>